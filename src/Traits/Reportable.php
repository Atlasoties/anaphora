<?php

namespace Jaktech\Anaphora\Traits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Jacktech\Anaphora\Exceptions\ArgumentExceptions;

/**
 * Trait Reportable.
 *
 * This trait provides methods for generating reports based on various time intervals.
 * Users can specify the column on which the report should be generated.
 */
trait Reportable
{
    /**
     * Generate a yearly report based on the specified column.
     *
     * @param Builder       $query
     * @param int|null      $year
     * @param string|null   $column
     *
     * @return Builder|\Illuminate\Database\Query\Builder
     */
    public function scopeYearlyReport(Builder $query, $year = null, $column = 'created_at')
    {
        $this->validateColumn($column);
        return $query->whereYear($column, $year ?? Carbon::now()->year);
    }

    /**
     * Generate a report for the current year based on the specified column.
     *
     * @param Builder     $query
     * @param string|null $column
     *
     * @return Builder|\Illuminate\Database\Query\Builder
     */
    public function scopeThisYearReport(Builder $query, $column = 'created_at')
    {
        $this->validateColumn($column);
        return $query->whereYear($column, Carbon::now()->year);
    }

    /**
     * Generate a report for the last year based on the specified column.
     *
     * @param Builder     $query
     * @param string|null $column
     *
     * @return Builder|\Illuminate\Database\Query\Builder
     */
    public function scopeLastYearReport(Builder $query, $column = 'created_at')
    {
        return $query->whereYear($column, Carbon::now()->subYear()->year);
    }

    /**
     * Generate a monthly report based on the specified column.
     *
     * @param Builder       $query
     * @param int|null      $month
     * @param int|null      $year
     * @param string|null   $column
     *
     * @return Builder|\Illuminate\Database\Query\Builder
     */
    public function scopeMonthlyReport(Builder $query, $month = null, $year = null, $column = 'created_at')
    {
        return $query->whereYear($column, $year ?? Carbon::now()->year)->whereMonth($column, $month ?? Carbon::now()->month);
    }

    /**
     * Generate a report for the current month based on the specified column.
     *
     * @param Builder     $query
     * @param string|null $column
     *
     * @return Builder|\Illuminate\Database\Query\Builder
     */
    public function scopeThisMonthReport(Builder $query, $column = 'created_at')
    {
        return $query->whereYear($column, Carbon::now()->year)->whereMonth($column, Carbon::now()->month);
    }

     /**
     * @param Builder $query
     *
     * @return Builder|\Illuminate\Database\Query\Builder
     */
    public function scopeLastMonthReport(Builder $query, $column = 'created_at')
    {
        return $query->whereYear($column, Carbon::now()->subMonth()->year)->whereMonth($column, Carbon::now()->subMonth()->month);
    }


    /**
     * Generate a report for the current week based on the specified column.
     *
     * @param Builder     $query
     * @param string|null $column
     *
     * @return Builder
     */
    public function scopeThisWeekReport(Builder $query, $column = 'created_at')
    {
        return $query->whereBetween($column, [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
    }

    /**
     * Generate a report for the last week based on the specified column.
     *
     * @param Builder     $query
     * @param string|null $column
     *
     * @return Builder
     */
    public function scopeLastWeekReport(Builder $query, $column = 'created_at')
    {
        return $query->whereBetween($column, [Carbon::now()->startOfWeek()->subWeek()->format('Y-m-d'), Carbon::now()->endOfWeek()->subWeek()->format('Y-m-d')]);
    }

    // ... (similar changes for other scopes)

    /**
     * Generate a daily report based on the specified column.
     *
     * @param Builder        $query
     * @param Carbon|null    $date
     * @param string|null    $column
     *
     * @return Builder|\Illuminate\Database\Query\Builder
     */
    public function scopeDailyReport(Builder $query, $date = null, $column = 'created_at')
    {
        return $query->whereDate($column, $date ?? Carbon::today());
    }

    /**
     * Generate a report for today based on the specified column.
     *
     * @param Builder     $query
     * @param string|null $column
     *
     * @return Builder|\Illuminate\Database\Query\Builder
     */
    public function scopeTodayReport(Builder $query, $column = 'created_at')
    {
        return $query->whereDate($column, Carbon::today());
    }

    /**
     * Generate a report for yesterday based on the specified column.
     *
     * @param Builder     $query
     * @param string|null $column
     *
     * @return Builder|\Illuminate\Database\Query\Builder
     */
    public function scopeYesterdayReport(Builder $query, $column = 'created_at')
    {
        return $query->whereDate($column, Carbon::yesterday());
    }

    /**
     * Generate an hourly report based on the specified column.
     *
     * @param Builder        $query
     * @param Carbon|null    $from
     * @param Carbon|null    $to
     * @param Carbon|null    $date
     * @param string|null    $column
     *
     * @return Builder|\Illuminate\Database\Query\Builder
     */
    public function scopeHourlyReport(Builder $query, $from = null, $to = null, $date = null, $column = 'created_at')
    {
        return $query->whereDate($column, $date ?? Carbon::today())->whereTime($column, '>', $from ?? Carbon::now()->subHour())->whereTime($column, '<=', $to ?? Carbon::now());
    }

    /**
     * Validate if the specified column exists in the model's table.
     *
     * @param string $column
     *
     * @throws ArgumentExceptions
     */
    private function validateColumn($column)
    {
        if (!in_array($column, $this->getColumns())) {
            throw new \Exception("Invalid column: $column");
        }
    }

    /**
     * Get all columns for the model's table.
     *
     * @return array
     */
    private function getColumns()
    {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
