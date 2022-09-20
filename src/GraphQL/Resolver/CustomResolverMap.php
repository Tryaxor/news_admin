<?php

namespace App\GraphQL\Resolver;

use App\Service\MutationService;
use App\Service\QueryService;
use ArrayObject;
use DateTime;
use GraphQL\Type\Definition\ResolveInfo;
use Overblog\GraphQLBundle\Definition\ArgumentInterface;
use Overblog\GraphQLBundle\Resolver\ResolverMap;

class CustomResolverMap extends ResolverMap
{
    public function __construct(
        private QueryService    $queryService,
        private MutationService $mutationService
    ) {}

    /**
     * @inheritDoc
     */
    protected function map(): array
    {
        return [
            'DateTime' => [
                self::SERIALIZE => function ($value) {
                    if (\is_string($value)) {
                        return DateTime::createFromFormat(DateTime::ISO8601, $value);
                    } elseif ($value instanceof DateTime) {
                        return $value->format(DateTime::ISO8601);
                    }

                    return null;
                },
                self::PARSE_VALUE => function ($value) {
                    if (\is_string($value)){
                        return DateTime::createFromFormat(DateTime::ISO8601, $value);
                    } elseif ($value instanceof DateTime) {
                        return $value;
                    }

                    return null;
                }
            ],
            'RootQuery'    => [
                self::RESOLVE_FIELD => function (
                    $value,
                    ArgumentInterface $args,
                    ArrayObject $context,
                    ResolveInfo $info
                ) {
                    return match ($info->fieldName) {
                        'findArticleById' => $this->queryService->findArticleById((int)$args['id']),
                        'findAllArticles' => $this->queryService->findAllArticles(),
                        default => null
                    };
                },
            ],
            'RootMutation' => [
                self::RESOLVE_FIELD => function (
                    $value,
                    ArgumentInterface $args,
                    ArrayObject $context,
                    ResolveInfo $info
                ) {
                    return match ($info->fieldName) {
                        'createArticle' => $this->mutationService->createArticle($args['author']),
                        'updateArticle' => $this->mutationService->updateArticle((int)$args['id'], $args['article']),
                        default => null
                    };
                },
            ],
        ];
    }
}