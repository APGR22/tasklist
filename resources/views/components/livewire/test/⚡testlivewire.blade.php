<?php

use Livewire\Component;

new class extends Component
{
    public $data = [
        "...",
        "Halo",
        "Ini adalah Livewire",
        "Tekan tombol \"Next\" lagi untuk ke text berikutnya",
        "Kamu berhasil!",
        "Selamat atas pencapaianmu",
        "Ayo lanjut~",
        "Kamu tidak apa-apa kan?",
        "Jangan lupa makan ya",
        "Tidak baik kalau koding terus tanpa istirahat",
        "Kamu pasti bisa!",
        "Oh tidak",
        "Sepertinya teks ini menuju ke indeks terakhir",
        "Sepertinya memang inilah akhirnya",
        "Meskipun aku reset, setidaknya aku pernah hadir dari awal hingga akhir di sesi ini",
        "Etto... Aku...",
        "Aku-@%#*@%(@*#)$#$",
        "@#@#*&)^)$%^&$(^$$!#@)"
    ];
    public $index = 0;

    public $livewireText = "";

    public function mount()
    {
        $this->livewireText = $this->data[0];
    }

    public function changeText()
    {
        $this->index++;

        $this->livewireText = $this->data[$this->index];

        $length = sizeof($this->data);
        $last_index = $length - 1;
        if ($this->index >= $last_index)
        {
            $this->index = -1;
        }
    }
};
?>

<div>
    {{-- Simplicity is the essence of happiness. - Cedric Bledsoe --}}

    <span wire:text="livewireText" class="text-primary text-black"></span><br>
    <button class="btn btn-primary" wire:click="changeText">Ganti teks</button>
</div>