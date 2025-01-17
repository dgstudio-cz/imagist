<?php declare(strict_types = 1);

namespace Contributte\Imagist\Testing\Filter;

use Contributte\Imagist\Entity\Filter\ImageFilter;
use Contributte\Imagist\Scope\Scope;

final class OperationRegistry implements OperationRegistryInterface
{

	/** @var OperationInterface[] */
	private array $operations = [];

	public function add(OperationInterface $operation): void
	{
		$this->operations[] = $operation;
	}

	public function get(ImageFilter $filter, Scope $scope): ?OperationInterface
	{
		foreach ($this->operations as $operation) {
			if ($operation->supports($filter, $scope)) {
				return $operation;
			}
		}

		return null;
	}

}
