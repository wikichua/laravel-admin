<?php

namespace Wikichua\LaravelBread\Controllers;

use App\Http\Controllers\Controller;
use Artisan;
use File;
use Illuminate\Http\Request;
use Response;
use View;

class BreadController extends Controller
{
    public function getGenerator()
    {
        return view('laravel-bread::generator');
    }
    public function postGenerator(Request $request)
    {
        $commandArg = [];
        $commandArg['name'] = $request->crud_name;

        if ($request->has('fields')) {
            $fieldsArray = [];
            $validationsArray = [];
            $x = 0;
            foreach ($request->fields as $field) {
                if ($request->fields_required[$x] == 1) {
                    $validationsArray[] = $field;
                }

                $fieldsArray[] = $field . '#' . $request->fields_type[$x];

                $x++;
            }

            $commandArg['--fields'] = implode(";", $fieldsArray);
        }

        if (!empty($validationsArray)) {
            $commandArg['--validations'] = implode("#required;", $validationsArray) . "#required";
        }

        if ($request->has('route')) {
            $commandArg['--route'] = $request->route;
        }

        if ($request->has('view_path')) {
            $commandArg['--view-path'] = $request->view_path;
        }

        if ($request->has('controller_namespace')) {
            $commandArg['--controller-namespace'] = $request->controller_namespace;
        }

        if ($request->has('model_namespace')) {
            $commandArg['--model-namespace'] = $request->model_namespace;
        }

        if ($request->has('route_group')) {
            $commandArg['--route-group'] = $request->route_group;
        }

        if ($request->has('relationships')) {
            $commandArg['--relationships'] = $request->relationships;
        }

        if ($request->has('form_helper')) {
            $commandArg['--form-helper'] = $request->form_helper;
        }

        if ($request->has('soft_deletes')) {
            $commandArg['--soft-deletes'] = $request->soft_deletes;
        }

        try {
            Artisan::call('bread:generate', $commandArg);

            $name = $commandArg['name'];
            $routeName = ($commandArg['--route-group']) ? $commandArg['--route-group'] . '/' . snake_case($name, '-') : snake_case($name, '-');

            $menus = config('menus');
            $menus[$request->menu_section][] = [
                'title' => $name,
                'url' => strtolower($name).'.index',
                'permission' => 'browse-'.strtolower($name),
            ];

            File::put(config_path('menus.php'), "<?php \nreturn\n" . var_export($menus, true) . ";");

            Artisan::call('migrate');
            \DB::table('permissions')->insert([
                ['name' => 'browse-'.strtolower($name), 'label' => 'Browse '.$name],
                ['name' => 'read-'.strtolower($name), 'label' => 'Read '.$name],
                ['name' => 'add-'.strtolower($name), 'label' => 'Add '.$name],
                ['name' => 'edit-'.strtolower($name), 'label' => 'Edit '.$name],
                ['name' => 'delete-'.strtolower($name), 'label' => 'Delete '.$name],
            ]);
        } catch (\Exception $e) {
            return Response::make($e->getMessage(), 500);
        }

        return redirect('admin/generator')->with('flash_message', 'Your CRUD has been generated. See on the menu.');
    }
}
