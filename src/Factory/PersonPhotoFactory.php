<?php

namespace App\Factory;

use App\Entity\PersonPhoto;
use App\Repository\PersonPhotoRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<PersonPhoto>
 *
 * @method        PersonPhoto|Proxy create(array|callable $attributes = [])
 * @method static PersonPhoto|Proxy createOne(array $attributes = [])
 * @method static PersonPhoto|Proxy find(object|array|mixed $criteria)
 * @method static PersonPhoto|Proxy findOrCreate(array $attributes)
 * @method static PersonPhoto|Proxy first(string $sortedField = 'id')
 * @method static PersonPhoto|Proxy last(string $sortedField = 'id')
 * @method static PersonPhoto|Proxy random(array $attributes = [])
 * @method static PersonPhoto|Proxy randomOrCreate(array $attributes = [])
 * @method static PersonPhotoRepository|RepositoryProxy repository()
 * @method static PersonPhoto[]|Proxy[] all()
 * @method static PersonPhoto[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static PersonPhoto[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static PersonPhoto[]|Proxy[] findBy(array $attributes)
 * @method static PersonPhoto[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static PersonPhoto[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class PersonPhotoFactory extends ModelFactory
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
        return [];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(PersonPhoto $personPhoto): void {})
        ;
    }

    protected static function getClass(): string
    {
        return PersonPhoto::class;
    }
}
