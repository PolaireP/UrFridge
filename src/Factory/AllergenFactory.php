<?php

namespace App\Factory;

use App\Entity\Allergen;
use App\Repository\AllergenRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Allergen>
 *
 * @method        Allergen|Proxy create(array|callable $attributes = [])
 * @method static Allergen|Proxy createOne(array $attributes = [])
 * @method static Allergen|Proxy find(object|array|mixed $criteria)
 * @method static Allergen|Proxy findOrCreate(array $attributes)
 * @method static Allergen|Proxy first(string $sortedField = 'id')
 * @method static Allergen|Proxy last(string $sortedField = 'id')
 * @method static Allergen|Proxy random(array $attributes = [])
 * @method static Allergen|Proxy randomOrCreate(array $attributes = [])
 * @method static AllergenRepository|RepositoryProxy repository()
 * @method static Allergen[]|Proxy[] all()
 * @method static Allergen[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Allergen[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static Allergen[]|Proxy[] findBy(array $attributes)
 * @method static Allergen[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Allergen[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class AllergenFactory extends ModelFactory
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
            'allergenName' => self::faker()->text(50),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Allergen $allergen): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Allergen::class;
    }
}
