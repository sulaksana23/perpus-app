@extends('layouts.app', ['title' => 'Login'])

@section('content')
    <section class="mx-auto mt-8 max-w-md rounded-xl border border-slate-200 bg-white p-4 shadow-sm md:p-5">
        <h1 class="flex items-center gap-2 text-xl font-bold text-slate-900">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-7.5a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 006 21h7.5a2.25 2.25 0 002.25-2.25V15M18 12H9m0 0l3-3m-3 3l3 3" />
            </svg>
            Login
        </h1>
        <p class="mt-1 text-sm text-slate-500">Silakan masuk dengan akun Anda.</p>

        <form action="{{ route('login.attempt') }}" method="POST" class="mt-4 space-y-4">
            @csrf
            <div>
                <label for="email" class="mb-1 block text-sm font-medium text-slate-700">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm outline-none ring-blue-500/30 focus:border-blue-500 focus:ring">
            </div>

            <div>
                <label for="password" class="mb-1 block text-sm font-medium text-slate-700">Password</label>
                <input type="password" id="password" name="password" required class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm outline-none ring-blue-500/30 focus:border-blue-500 focus:ring">
            </div>

            <label class="inline-flex items-center gap-2 text-sm text-slate-600">
                <input type="checkbox" id="remember" name="remember" value="1" class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                Ingat saya
            </label>

            <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-blue-600 px-3 py-2 text-sm font-semibold text-white transition hover:bg-blue-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-7.5a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 006 21h7.5a2.25 2.25 0 002.25-2.25V15M18 12H9m0 0l3-3m-3 3l3 3" />
                </svg>
                Masuk
            </button>
        </form>

        <p class="mt-3 text-sm text-slate-500">Belum punya akun? <a href="{{ route('register') }}" class="font-semibold text-blue-600 hover:text-blue-700">Daftar di sini</a>.</p>

        <p class="mt-3 rounded-lg bg-slate-50 px-3 py-2 text-xs text-slate-500">
            Default admin: <code class="font-semibold text-slate-700">admin@example.com</code> / <code class="font-semibold text-slate-700">password123</code>
        </p>
    </section>
@endsection
