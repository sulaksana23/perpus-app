@if(session('success'))
    <div class="alert border-0 text-white" style="background: linear-gradient(135deg, #059669, #10b981); border-radius: 14px;">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert border-0 text-white" style="background: linear-gradient(135deg, #dc2626, #ef4444); border-radius: 14px;">
        {{ session('error') }}
    </div>
@endif

@if($errors->any())
    <div class="alert border-0 text-white" style="background: linear-gradient(135deg, #b91c1c, #ef4444); border-radius: 14px;">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
