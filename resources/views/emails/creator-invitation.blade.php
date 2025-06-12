<x-mail::message>
    # Selamat Datang, {{ $name }}!

    Kami sangat senang Anda bergabung sebagai Content Creator di platform kami.

    Akun Anda telah berhasil dibuat. Berikut adalah detail login Anda:

    - **Username:** `{{ $username }}`
    - **Password:** `{{ $password }}`

    Anda dapat login ke akun Anda sekarang untuk mulai membuat konten menarik:

    <x-mail::button :url="$loginUrl">
        Login Sekarang
    </x-mail::button>

    Jika ada pertanyaan, jangan ragu untuk menghubungi kami.

    Terima Kasih,
    {{ config('app.name') }}
</x-mail::message>
