<div class="mr-6 px-3 py-1 bg-primary-50 dark:bg-primary-900/20 rounded-lg border border-primary-200 dark:border-primary-800">
    <x-filament::input.wrapper>
        <x-filament::input.select wire:model.live="mode">
            <option value="print">🖨️ Print</option>
            <option value="transaction">💲 Transaction</option>
        </x-filament::input.select>
    </x-filament::input.wrapper>
</div>
