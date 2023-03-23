<?php

namespace Clonixdev\LaravelBill\Http\Controllers;

use Illuminate\Database\Eloquent\Model;

class ApiBaseController extends Controller
{

    protected $classname;
    protected $default_page_size = 20;

    public function index()
    {
        $query = $this->classname::orderByDesc('id');
        $this->filter($query);
        return $this->results($query);
    }


    public function show()
    {
        $request = request();
        $id = $request->id;
        return $this->classname::where('id',$id)->firstOrFail();
    }

    public function destroy()
    {
        $request = request();
        $id = $request->id;
        return $this->classname::where('id',$id)->delete();
    }

    public function update()
    {
        $request = request();
        $id = $request->id;
        $model = $this->classname::findOrFail($id);
        $model->update($request->all());
        return $model;
    }

    public function store()
    {
        $request = request();
        $values = $request->all();
        return $this->classname::create($values);
    }

    protected function results($query){
        $request = request();
        $limit = $request->limit ? $request->limit : $this->default_page_size;
        return $query->paginate($limit);
    }

    protected function filter($query)
    {
        $request = request();
        $request_filters = $request->filters;
        if ($request_filters) {
            $filters = json_decode($request_filters);
            if (defined($this->classname . '::SEARCH_COLUMNS') && $this->classname::SEARCH_COLUMNS != null) {
                $this->filterFromArray($query, $filters, $this->classname::SEARCH_COLUMNS);
            } else {
                $this->filterFromArray($query, $filters);
            }
        }
    }

    protected function filterFromArray($query, $filters, $searchColumns = ['name'])
    {

        if (!is_array($filters)) return;
        foreach ($filters as $filter) {
            $column = $filter[0];
            $operator = $filter[1];
            $value = $filter[2];
            if ($column == "search") {
                $query->where(function ($query) use ($value, $searchColumns) {
                    $i = 0;
                    foreach ($searchColumns as $sc) {

                        if ($i == 0) {
                            $query->where($sc, 'like', '%' . $value . '%');
                        } else {
                            $query->orWhere($sc, 'like', '%' . $value . '%');
                        }


                        $i++;
                    }
                });
            } else {
                if ($operator == "CONTAINS") {
                    $query->whereJsonContains($column, $value);
                }
                else if ($operator == "IN") {

                    if (count($value) == 1) {
                        $query->where($column, "=", $value);
                    } else if (count($value) > 1) {
                        $query->whereIn($column, $value);
                    }
                } else if ($operator == "SORTASC") {
                    $query->orderBy($column);
                } else if ($operator == "SORTDESC") {
                    $query->orderBy($column, 'DESC');
                } else {
                    $query->where($column, $operator, $value);
                }
            }
        }
    }

}
