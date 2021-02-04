<?php

namespace App\Vatsim;

use Illuminate\Support\Collection;

class Structure
{
    private array $generalData;
    private Collection $pilots;

    /**
     * @return array
     */
    public function getGeneralData(): array
    {
        return $this->generalData;
    }

    /**
     * @param array $generalData
     *
     * @return Structure
     */
    public function setGeneralData(array $generalData): self
    {
        $this->generalData = $generalData;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getPilots(): Collection
    {
        return $this->pilots;
    }

    /**
     * @param array $pilots
     *
     * @return Structure
     */
    public function setPilots(array $pilots): self
    {
        $this->pilots = collect($pilots);
        return $this;
    }
}
