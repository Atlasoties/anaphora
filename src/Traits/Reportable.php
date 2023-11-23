<?php

namespace Jaktech\Anaphora\Traits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

/**
 * Trait Reportable.
 */
trait Reportable
{
    /**
     * @param Builder $query
     * @param Carbon|null    $year
     *
     * @return Builder|\Illuminate\Database\Query\Builder
     */
    public function scopeYearlyReport(Builder $query, $year = null, $column = 'created_at')
    {
        return $query->whereYear($column, $year ?? Carbon::now()->year);
    }

    /**
     * @param Builder $query
     *
     * @return Builder|\Illuminate\Database\Query\Builder
     */
    public function scopeThisYearReport(Builder $query, $column = 'created_at')
    {
        return $query->whereYear($column, Carbon::now()->year);
    }

    /**
     * @param Builder $query
     *
     * @return Builder|\Illuminate\Database\Query\Builder
     */
    public function scopeLastYearReport(Builder $query, $column = 'created_at')
    {
        return $query->whereYear($column, Carbon::now()->subYear()->year);
    }

    /**
     * @param Builder $query
     * @param Carbon|null    $month
     * @param Carbon|null    $year
     *
     * @return Builder|\Illuminate\Database\Query\Builder
     */
    public function scopeMonthlyReport(Builder $query, $month = null, $year = null, $column = 'created_at')
    {
        return $query->whereYear($column, $year ?? Carbon::now()->year)->whereMonth($column, $month ?? Carbon::now()->month);
    }

    /**
     * @param Builder $query
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
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeThisWeekReport(Builder $query, $column = 'created_at')
    {
        return $query->whereBetween($column, [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
    }

    /**
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeLastWeekReport(Builder $query, $column = 'created_at')
    {
        return $query->whereBetween($column, [Carbon::now()->startOfWeek()->subWeek()->format('Y-m-d'), Carbon::now()->endOfWeek()->subWeek()->format('Y-m-d')]);
    }

    /**
     * @param Builder $query
     * @param Carbon|null    $date
     *
     * @return Builder|\Illuminate\Database\Query\Builder
     */
    public function scopeDailyReport(Builder $query, $date = null, $column = 'created_at')
    {
        return $query->whereDate($column, $date ?? Carbon::today());
    }

    /**
     * @param Builder $query
     *
     * @return Builder|\Illuminate\Database\Query\Builder
     */
    public function scopeTodayReport(Builder $query, $column = 'created_at')
    {
        return $query->whereDate($column, Carbon::today());
    }

    /**
     * @param Builder $query
     *
     * @return Builder|\Illuminate\Database\Query\Builder
     */
    public function scopeYesterdayReport(Builder $query, $column = 'created_at')
    {
        return $query->whereDate($column, Carbon::yesterday());
    }

    /**
     * @param Builder $query
     * @param Carbon|null    $from
     * @param Carbon|null    $to
     * @param Carbon|null    $date
     *
     * @return Builder|\Illuminate\Database\Query\Builder
     */
    public function scopeHourlyReport(Builder $query, $from = null, $to = null, $date = null, $column = 'created_at')
    {
        return $query->whereDate($column, $date ?? Carbon::today())->whereTime($column, '>', $from ?? Carbon::now()->subHour())->whereTime($column, '<=', $to ?? Carbon::now());
    }
}