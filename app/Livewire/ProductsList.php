<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;

class ProductsList extends Component
{
    use WithPagination;

    public $sort = 'created_at';
    public $direction = 'desc';

    protected $queryString = ['sort', 'direction'];

    public function sortBy($field)
    {
        if ($this->sort === $field) {
            $this->direction = $this->direction === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sort = $field;
            $this->direction = 'asc';
        }
    }
    
    public function render()
    {
        return view('livewire.products-list', [
            'products' => Product::with('images')
                ->orderBy($this->sort, $this->direction)
                ->paginate(25),
        ]);
    }
}
