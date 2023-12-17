<?php

namespace App\Factory;

use App\Entity\Inventory;
use App\Repository\InventoryRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Inventory>
 *
 * @method        Inventory|Proxy create(array|callable $attributes = [])
 * @method static Inventory|Proxy createOne(array $attributes = [])
 * @method static Inventory|Proxy find(object|array|mixed $criteria)
 * @method static Inventory|Proxy findOrCreate(array $attributes)
 * @method static Inventory|Proxy first(string $sortedField = 'id')
 * @method static Inventory|Proxy last(string $sortedField = 'id')
 * @method static Inventory|Proxy random(array $attributes = [])
 * @method static Inventory|Proxy randomOrCreate(array $attributes = [])
 * @method static InventoryRepository|RepositoryProxy repository()
 * @method static Inventory[]|Proxy[] all()
 * @method static Inventory[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Inventory[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static Inventory[]|Proxy[] findBy(array $attributes)
 * @method static Inventory[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Inventory[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class InventoryFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Inventory $inventory): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Inventory::class;
    }
}
