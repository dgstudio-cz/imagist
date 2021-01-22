<?php declare(strict_types = 1);

namespace Contributte\Imagist\Resolver\DefaultImageResolvers;

use Contributte\Imagist\Entity\PersistentImageInterface;
use Contributte\Imagist\LinkGeneratorInterface;
use Contributte\Imagist\Resolver\DefaultImageResolverInterface;

final class NullDefaultImageResolver implements DefaultImageResolverInterface
{

	/**
	 * @param mixed[] $options
	 */
	public function resolve(
		LinkGeneratorInterface $linkGenerator,
		?PersistentImageInterface $image,
		array $options = []
	): ?string
	{
		return null;
	}

}
