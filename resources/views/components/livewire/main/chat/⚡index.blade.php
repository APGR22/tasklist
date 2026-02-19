<?php

use Livewire\Component;
use App\Models\Task;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ChatController;

new class extends Component
{
    #[Locked]
    public $uuid_group;
    #[Locked]
    public $uuid_task;

    #[Locked]
    public $uuid_chat;

    #[Locked]
    public $__table_chat = "";

    public function mount($uuid_group, $uuid_task)
    {
        $this->uuid_group = $uuid_group;
        $this->uuid_task = $uuid_task;

        $task = Task::where('uuid', '=', $uuid_task)->first();
        $chat = Chat::find($task->chat_id);

        $this->uuid_chat = $chat->uuid;

        foreach ($chat->data as $msgdata)
        {
            $this->addToTable($msgdata);
        }
    }

    public function addToTable($msgdata)
    {
        $user = User::find($msgdata['user_id']);
        $current_user_id = Auth::id();

        $content = "&emsp;{$msgdata['message']}<br>";

        $header = "";

        if ($user->id == $current_user_id)
        {
            $header = "
            <p id=\"{$msgdata['uuid']}\" class=\"text-end\">
            From {$user->username}<<br>
            ";
        }
        else
        {
            $header = "
            <p id=\"{$msgdata['uuid']}\">
            >From {$user->username}<br>
            ";
        }

        $footer = "
        {$msgdata['datetime']}
        </p>
        ";

        $content = $header.$content.$footer;

        $this->__table_chat .= $content;
    }

    public function InternalMessageSend(string $inputText)
    {
        if ($this->CheckIfMessageEmpty($inputText)) return;

        $message = $inputText;

        $msg = ChatController::createMessage(
            Auth::id(),
            $this->uuid_group,
            $this->uuid_task,
            $this->uuid_chat,
            $message
        );

        $chat = Chat::where('uuid', '=', $this->uuid_chat)->first();
        // menyimpan data pesan baru
        ChatController::addToDatabase($chat->id, $msg);

        $this->addToTable($msg);

        $this->js('clearInput');
        $this->js('buttonSend');
    }

    private function CheckIfMessageEmpty(string $message)
    {
        if ($message == '') return true;

        // https://stackoverflow.com/questions/4601032/loop-over-each-character-in-a-string
        foreach (str_split($message) as $char)
        {
            if ($char != ' ') return false;
        }

        return true;
    }

    private function buttonLoading()
    {
        $this->__send_button = "
        <div class=\"spinner-border\" role=\"status\">
        <span class=\"visually-hidden\">Loading...</span>
        </div>
        ";
    }

    private function buttonSend()
    {
        $this->__send_button = "Send";
    }
};
?>

<div>
    {{-- I begin to speak only when I am certain what I will say is not better left unsaid. - Cato the Younger --}}

    
    <a href="{{ url('/group/'.$uuid_group) }}">
        <button class="btn btn-secondary">Back</button>
    </a><br>

    <div class="d-flex align-content-end flex-wrap container-fluid bg-primary position-absolute bottom-0 p-0" style="height: 80vh !important">
        <div class="container-fluid h-100 overflow-y-scroll bg-info">
            {!! $__table_chat !!}
        </div>
        <div class="d-flex justify-content-evenly container-fluid bg-warning p-0">
            <input type="text" class="flex-fill" id="message-input-user">
            <button class="btn btn-primary" wire:click="$js.msgSend()" id="message-button-user">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-send" viewBox="0 0 16 16">
                    <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576zm6.787-8.201L1.591 6.602l4.339 2.76z"/>
                </svg>
            </button>
        </div>
    </div>
</div>

<script>
    const input = document.getElementById("message-input-user")
    const sendButton = document.getElementById("message-button-user")

    function init()
    {
        input.addEventListener("keypress", function (event) {
            if (event.key !== "Enter") return

            event.preventDefault()

            sendButton.click()
        })

        sendButton.addEventListener("click", function (event) {
            if (input.value === "") return

            event.preventDefault()

            buttonLoading()
        })
    }
    init()

    function buttonSend()
    {
        sendButton.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-send" viewBox="0 0 16 16">
            <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576zm6.787-8.201L1.591 6.602l4.339 2.76z"/>
        </svg>
        `
    }

    function buttonLoading()
    {
        sendButton.innerHTML = `
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        `
    }

    this.$js.msgSend = () =>
    {
        // RSA Algorithm Code

        // https://livewire.laravel.com/docs/4.x/javascript#the-wire-object-1
        $wire.$call('InternalMessageSend', input.value)
    }

    this.$js.clearInput = () =>
    {
        const input = document.getElementById("message-input-user")
        input.value = ""
    }

    this.$js.buttonSend = buttonSend;
</script>