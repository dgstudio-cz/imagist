<?php declare(strict_types = 1);

namespace Contributte\Imagist\Persister;

use Contributte\Imagist\Context\Context;
use Contributte\Imagist\Entity\EmptyImageInterface;
use Contributte\Imagist\Entity\ImageInterface;
use Contributte\Imagist\Entity\PersistentImageInterface;
use Contributte\Imagist\Exceptions\InvalidArgumentException;

final class PersistentImagePersister extends ImagePersisterAbstract
{

	private bool $strict = true;

	public function setStrict(bool $strict): void
	{
		$this->strict = $strict;
	}

	public function supports(ImageInterface $image, Context $context): bool
	{
		return $image instanceof PersistentImageInterface && !$image instanceof EmptyImageInterface;
	}

	public function persist(ImageInterface $image, Context $context): ImageInterface
	{
		if (!$image->getFilter()) {
			if ($this->strict) {
				throw new InvalidArgumentException('Cannot persist persistent image with no filter');
			}

			return $image;
		}

		$this->save($image, $context);

		return $image;
	}

}
