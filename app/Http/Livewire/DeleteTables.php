<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DeleteTables extends Component
{
    public $confirmation = false;

    public function deleteAllTables()
    {
        try {
            // Disable foreign key checks to avoid constraint issues
            DB::statement('SET FOREIGN_KEY_CHECKS = 0');
    
            // Get all table names
            $tables = DB::select('SHOW FULL TABLES WHERE Table_Type = "BASE TABLE"');
    
            // Drop each table
            foreach ($tables as $table) {
                $tableName = array_values((array) $table)[0];
                Schema::dropIfExists($tableName);
            }
    
            // Enable foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    
            // Notify success
            session()->flash('status', 'All tables have been successfully deleted!');
        } catch (\Exception $e) {
            // Notify error
            session()->flash('error', 'Failed to delete tables: ' . $e->getMessage());
        }
    
        $this->confirmation = false; // Reset confirmation state
    }    

    public function render()
    {
        return view('livewire.delete-tables-view'); // Specify a new view file
    }
}
