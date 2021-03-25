<?php declare(strict_types = 1);

namespace Contributte\Imagist\Bridge\Doctrine\Event;

use Contributte\Imagist\ImageStorageInterface;
use Contributte\Imagist\Transaction\TransactionFactoryInterface;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;

final class RemoveEvent implements EventSubscriber
{

	private TransactionFactoryInterface $transactionFactory;

	public function __construct(TransactionFactoryInterface $transactionFactory, ImageStorageInterface $imageStorage)
	{
		$this->transactionFactory = $transactionFactory;
	}

	/**
	 * @return mixed[]
	 */
	public function getSubscribedEvents(): array
	{
		return [
			Events::postRemove,
		];
	}

	public function postRemove(LifecycleEventArgs $args): void
	{
		$object = $args->getObject();
		$em = $args->getObjectManager();

		if (!$object instanceof ImageCleaner) {
			return;
		}

		$images = array_filter($object->_imagesToClean());
		if (!$images) {
			return;
		}

		$transaction = $this->transactionFactory->create();
		foreach ($images as $image) {
			if (!$image->isEmpty()) {
				$transaction->remove($image);
			}
		}

		$transaction->commit();
	}

}