<?php declare(strict_types = 1);

namespace Contributte\Imagist\Bridge\Gumlet;

use InvalidArgumentException;
use JetBrains\PhpStorm\ExpectedValues; // phpcs:ignore

class GumletBuilder
{

	/** @var mixed[] */
	private array $options = [];

	/**
	 * @return self
	 */
	public static function create()
	{
		return new self();
	}

	/**
	 * @return self
	 */
	public function resize(?int $width, ?int $height = null, ?string $mode = null)
	{
		if (($width ?? $height) === null) {
			throw new InvalidArgumentException('Height or width must be set');
		}

		if ($width !== null) {
			$this->options['w'] = $width;
		}

		if ($height !== null) {
			$this->options['h'] = $height;
		}

		if ($mode !== null) {
			$this->options['mode'] = $mode;
		}

		return $this;
	}

	/**
	 * @return self
	 */
	public function crop(
		#[ExpectedValues(['entropy', 'smart', 'top', 'topleft', 'left', 'bottomleft', 'bottom', 'bottomright', 'right', 'topright', 'faces', 'center'])]
		string $mode
	)
	{
		$this->options['crop'] = $mode;

		return $this;
	}

	/**
	 * @return mixed[]
	 */
	public function build(): array
	{
		return $this->options;
	}

}
