<?php

namespace App\Factory;

use App\Entity\Commentary;
use App\Repository\CommentaryRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Commentary>
 *
 * @method        Commentary|Proxy create(array|callable $attributes = [])
 * @method static Commentary|Proxy createOne(array $attributes = [])
 * @method static Commentary|Proxy find(object|array|mixed $criteria)
 * @method static Commentary|Proxy findOrCreate(array $attributes)
 * @method static Commentary|Proxy first(string $sortedField = 'id')
 * @method static Commentary|Proxy last(string $sortedField = 'id')
 * @method static Commentary|Proxy random(array $attributes = [])
 * @method static Commentary|Proxy randomOrCreate(array $attributes = [])
 * @method static CommentaryRepository|RepositoryProxy repository()
 * @method static Commentary[]|Proxy[] all()
 * @method static Commentary[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Commentary[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static Commentary[]|Proxy[] findBy(array $attributes)
 * @method static Commentary[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Commentary[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class CommentaryFactory extends ModelFactory
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
            'commentaryContent' => self::faker()->text(100),
            'commentaryPubDate' => self::faker()->dateTime(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Commentary $commentary): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Commentary::class;
    }
}
