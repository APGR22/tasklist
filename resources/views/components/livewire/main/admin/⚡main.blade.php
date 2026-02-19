<?php

use Livewire\Component;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;

new class extends Component
{
    #[Locked]
    public $users_uuid = [];
    #[Locked]
    public $admins_uuid = [];

    #[Locked]
    public $__users_table_content = "";
    #[Locked]
    public $__admins_table_content = "";

    /**
     * @param Collection<int, User> $users
     * @param Collection<int, Admin> $admins
     */
    public function mount($users, $admins)
    {
        foreach ($users as $user)
        {
            array_push($this->users_uuid, $user->uuid);
            $this->addToUsersTable($user);
        }

        foreach ($admins as $admin)
        {
            array_push($this->admins_uuid, $admin->uuid);
            $this->addToAdminsTable($admin);
        }
    }

    /**
     * @param User $user
     */
    public function addToUsersTable($user)
    {
        $uuid = $user->uuid;
        $username = $user->username;
        $is_logged = UserController::isLogged($user) ? 'true' : 'false';

        $current_user = Auth::user();

        $button = "";
        if ($current_user == $user)
        {
            $button = "
            <button class=\"btn btn-danger\" disabled>Remove</button>
            ";
        }
        else
        {
            $button = "
            <button class=\"btn btn-danger\">Remove</button>
            ";
        }

        $content = "
        <tr id=\"{$uuid}\">
            <td>{$uuid}</td>
            <td>{$username}</td>
            <td>{$is_logged}</td>
            <td>
                {$button}
            </td>
        </tr>
        ";

        $this->__users_table_content .= $content;
    }

    /**
     * @param Admin $admin
     */
    public function addToAdminsTable($admin)
    {
        $uuid = $admin->uuid;
        $username = $admin->username;
        $is_logged = AdminController::isLogged($admin) ? 'true' : 'false';

        $current_admin = Auth::guard('admin')->user();

        $button = "";
        if ($current_admin == $admin)
        {
            $button = "
            <button class=\"btn btn-danger\" disabled>Remove</button>
            ";
        }
        else
        {
            $button = "
            <button class=\"btn btn-danger\">Remove</button>
            ";
        }

        $content = "
        <tr id=\"{$uuid}\">
            <td>{$uuid}</td>
            <td>{$username}</td>
            <td>{$is_logged}</td>
            <td>
                {$button}
            </td>
        </tr>
        ";

        $this->__admins_table_content .= $content;
    }
};
?>

<div>
    {{-- Always remember that you are absolutely unique. Just like everyone else. - Margaret Mead --}}

    <table class="table table-primary">
        <thead>
            <tr>
                <th>UUID</th>
                <th>Admin</th>
                <th>Logged</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            {!! $__admins_table_content !!}
        </tbody>
    </table>
    <br>
    <table class="table table-primary">
        <thead>
            <tr>
                <th>UUID</th>
                <th>User</th>
                <th>Logged</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            {!! $__users_table_content !!}
        </tbody>
    </table>
</div>