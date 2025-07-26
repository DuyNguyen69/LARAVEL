<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\VehicleStoreRequest;
use App\Http\Requests\Admin\VehicleUpdateRequest;
use App\Models\Category;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index(Request $request)
    {
        $itemPerPage = env('ITEM_PER_PAGE', 5);
        $keyword = $request->keyword ?? null;
        $sort = $request->sort ?? 'latest';
        $categoryId = $request->category_id ?? null;
        switch ($sort) {
            case 'oldest':
                $column = 'id';
                $direction = 'asc';
                break;
            case 'price_asc':
                $column = 'price_per_day';
                $direction = 'asc';
                break;
            case 'price_desc':
                $column = 'price_per_day';
                $direction = 'desc';
                break;
            default:
                $column = 'id';
                $direction = 'desc';
        }
        $query = Vehicle::with('ProductCategory')->orderBy($column, $direction);
        if ($keyword) {
            $query->where('name', 'LIKE', "%$keyword%");
        }
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }
        $datas = $query->paginate($itemPerPage);
        $categories = Category::all();
        return view('admin.pages.vehicle.cars_list', ['datas' => $datas, 'itemPerPage' => $itemPerPage, 'categories' => $categories,]);
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.pages.vehicle.create', compact('categories'));
    }


    public function store(VehicleStoreRequest $request)
    {
        $car = new Vehicle();
        // Gán dữ liệu cơ bản
        $car->name = $request->name;
        $car->brand = $request->brand;
        $car->price_per_day = (int) str_replace(['.', '₫'], '', $request->input('price_per_day'));
        $car->status = $request->status;
        $car->description = $request->description;

        // Xử lý ảnh nếu có
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('admin_asset/images'), $filename);
            $car->image = 'admin_asset/images/' . $filename;
        }


        $car->category_id = $request->input('category_id');

        $saved = $car->save();

        return redirect()->route('admin.vehicle.index')->with('msg', $saved ? 'Success' : 'Fail');
    }
    public function destroy(Vehicle $car)
    {
        $msg = $car->delete() ? 'Success' : 'Fail';
        return redirect()->route('admin.vehicle.index')->with('msg', $msg);
    }

    public function detail(Vehicle $car)
    {
        $categories = Category::all();
        return view('admin.pages.vehicle.detail', compact('categories'))->with('data', $car);
    }
    public function update(VehicleUpdateRequest $request, Vehicle $car)
    {
        $car->name = $request->name;
        $car->brand = $request->brand;
        $car->price_per_day = $request->price_per_day;
        $car->status = $request->status;
        $car->description = $request->description;


        if ($request->hasFile('image')) {

            if ($car->image && file_exists(public_path($car->image))) {
                unlink(public_path($car->image));
            }

            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('admin_asset/images'), $filename);
            $car->image = 'admin_asset/images/' . $filename;
        }


        if ($request->has('category_id')) {
            $car->category_id = $request->category_id;
        }

        $check = $car->save();

        return redirect()->route('admin.vehicle.index')->with('msg', $check ? 'Success' : 'Fail');
    }
    public function trash()
    {
        $cars = Vehicle::onlyTrashed()->paginate(10);

        return view('admin.pages.vehicle.trash', compact('cars'));
    }

    public function restore(string $id)
    {
        $car = Vehicle::withTrashed()->find($id);

        $car->restore();

        return redirect()->route('admin.vehicle.index')->with('msg', 'Success');
    }
    public function forceDelete($id)
    {
        $car = Vehicle::onlyTrashed()->findOrFail($id);

        // Xoá ảnh
        if ($car->image && file_exists(public_path($car->image))) {
            unlink(public_path($car->image));
        }

        $car->forceDelete();

        return redirect()->back()->with('msg', 'Delete');
    }
}
