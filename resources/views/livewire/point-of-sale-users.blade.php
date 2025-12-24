<div class="space-y-6">
    <x-slot name="heading">
        {{ "Agents du point de vente {$this->pointOfSale->name}" }}
    </x-slot>

    <div style="margin-top: 16px">
        {{ $this->table }}
    </div>
</div>
