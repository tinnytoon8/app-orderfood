<?php

namespace App\Filament\Traits;

use Exception;
use Filament\Forms\Components\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

trait HasParentResource
{
    public Model|int|string|null $parent = null;

    public function bootHasParentResource(): void
    {
        if($parent = (request()->route('parent') ?? request()->input('parent'))) {
            $parentResource = $this->gerParentResource();

            $this->parent = $parentResource::resolveRecordRouteBinding($parent);

            if(!$this->parent){
                throw new ModelNotFoundException();
            }
        }
    }

    public static function getParentResource(): string
    {
        $parentResource = static::getResource()::$parentResource;

        if(!isset($parentResource)){
            throw new Exception('Parent resource is not set for'. static::class);
        }

        return $parentResource;
    }

    protected function applyFiltersToTableQuery(Builder $query): Builder
    {
        $query = parent::applyFiltersToTableQuery($query);

        return $query->where($this->getParentRelationshipKey(), $this->parent->getKey);
    }

    public function getParentRelationshipKey(): string
    {
        return $this->parent?->getForeignKey();
    }

    public function getChildPageNamePrefix(): string
    {
        return $this->pageNamePrefix ?? (string) str(static::getResource()::getSlug())
            ->replace('/', '.')
            ->afterLast('.');
    }

    public function getBreadCrumbs(): array
    {
        $resource = static::getResource();
        $parentResource = static::getParentResource();

        $breadcrumbs = [
            $parentResource::getUrl() => $parentResource::getBreadCrumb(),
            $parentResource::getRecordTitle($this->parent),
            $parentResource::getUrl(name: $this->getChildPageNamePrefix() . '.index')
        ];

        if(isset($this->record)){
            $breadcrumb[] = $resource::getRecordTitle($this->record);
        }

        $breadcrumb[] = $this->getBreadCrumb();

        return $breadcrumbs;
    }
}