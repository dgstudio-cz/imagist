<?php declare(strict_types = 1);

namespace Contributte\Imagist\LinkGenerator;

use Contributte\Imagist\Entity\EmptyImageInterface;
use Contributte\Imagist\Entity\PersistentImageInterface;
use Contributte\Imagist\Exceptions\FileNotFoundException;
use Contributte\Imagist\File\FileFactoryInterface;
use Contributte\Imagist\ImageStorageInterface;
use Contributte\Imagist\LinkGeneratorInterface;
use Contributte\Imagist\Resolver\DefaultImageResolverInterface;

final class LinkGenerator implements LinkGeneratorInterface
{

	private ImageStorageInterface $imageStorage;

	private FileFactoryInterface $fileFactory;

	private DefaultImageResolverInterface $defaultImageResolver;

	public function __construct(
		ImageStorageInterface $imageStorage,
		FileFactoryInterface $fileFactory,
		DefaultImageResolverInterface $defaultImageResolver
	)
	{
		$this->imageStorage = $imageStorage;
		$this->fileFactory = $fileFactory;
		$this->defaultImageResolver = $defaultImageResolver;
	}

	/**
	 * @inheritDoc
	 */
	public function link(?PersistentImageInterface $image, array $options = []): ?string
	{
		if (!$image || $image instanceof EmptyImageInterface) {
			return $this->defaultImageResolver->resolve($this, $image, $options);
		}

		$file = $this->fileFactory->create($image);
		if (!$file->exists()) {
			$image = $file->getImage();
			assert($image instanceof PersistentImageInterface);

			if (!$image->hasFilter()) {
				return $this->defaultImageResolver->resolve($this, $image, $options);
			}

			try {
				$image = $this->imageStorage->persist($image);
			} catch (FileNotFoundException $exception) {
				return $this->defaultImageResolver->resolve($this, $image, $options);
			}

			return '/' . $this->fileFactory->create($image)
				->getPath();
		}

		return '/' . $file->getPath();
	}

}
