<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class KiemTraTGCTGG implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    protected $start;
    protected $end;
    protected $MaCTGG;

    public function __construct($start, $end, $MaCTGG = null)
    {
        $this->start = $start;
        $this->end = $end;
        $this->MaCTGG = $MaCTGG;
    }
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->start) {
            return;
        }

        if(!$this->end){
            return;
        }

        $query = DB::table('tbl_chuongtrinhgiamgia')
            ->where(function ($query) {
                $query->where(function ($query) {
                    $query->where('ThoiGianBatDau', '<=', $this->start)
                        ->where('ThoiGianKetThuc', '>=', $this->start);
                })->orWhere(function ($query) {
                    $query->where('ThoiGianBatDau', '<=', $this->end)
                        ->where('ThoiGianKetThuc', '>=', $this->end);
                })->orWhere(function ($query) {
                    $query->where('ThoiGianBatDau', '>=', $this->start)
                        ->where('ThoiGianBatDau', '<=', $this->end);
                });
            });


        if ($query->count() > 0) {
            $fail('Thời gian của chương trình giảm giá bị gối lên nhau với một chương trình khác.');
        }

    }
}
