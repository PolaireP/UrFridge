<?php

namespace App\Factory;

use App\Entity\Equipment;
use App\Repository\EquipmentRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Equipment>
 *
 * @method        Equipment|Proxy create(array|callable $attributes = [])
 * @method static Equipment|Proxy createOne(array $attributes = [])
 * @method static Equipment|Proxy find(object|array|mixed $criteria)
 * @method static Equipment|Proxy findOrCreate(array $attributes)
 * @method static Equipment|Proxy first(string $sortedField = 'id')
 * @method static Equipment|Proxy last(string $sortedField = 'id')
 * @method static Equipment|Proxy random(array $attributes = [])
 * @method static Equipment|Proxy randomOrCreate(array $attributes = [])
 * @method static EquipmentRepository|RepositoryProxy repository()
 * @method static Equipment[]|Proxy[] all()
 * @method static Equipment[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Equipment[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static Equipment[]|Proxy[] findBy(array $attributes)
 * @method static Equipment[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Equipment[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class EquipmentFactory extends ModelFactory
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
            'equipmentName' => self::faker()->text(50),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Equipment $equipment): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Equipment::class;
    }
}
