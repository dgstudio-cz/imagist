<?php declare(strict_types = 1);

namespace Contributte\Imagist\Context;

use Contributte\Imagist\Entity\ImageInterface;

final class ContextImageAware implements ContextInterface
{

	private ContextInterface $context;

	private ImageInterface $image;

	public function __construct(ImageInterface $image, ?ContextInterface $context = null)
	{
		$this->context = $context ?? new Context();
		$this->image = $image;
	}

	public function getImage(): ImageInterface
	{
		return $this->image;
	}

	public function has(string $key): bool
	{
		return $this->context->has($key);
	}

	public function get(string $key, mixed $default = null): mixed // phpcs:ignore SlevomatCodingStandard.TypeHints.NullableTypeForNullDefaultValue.NullabilitySymbolRequired
	{
		return $this->context->get($key, $default);
	}

	public function set(string $key, mixed $value): ContextInterface
	{
		return $this->context->set($key, $value);
	}

}
