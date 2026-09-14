@extends('layouts.app')

@section('title')
    บทความ
@endsection

@section('content')
    <h2>บทความทั้งหมด</h2>

    @if (count($blogs) > 0)
    <table class="table table-bordered text-center">
        <thead class="table-info">
            <tr>
                <th scope="col">Title</th>
                {{-- <th scope="col">Content</th> --}}
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($blogs as $item)
                <tr>
                    <td>{{ $item->title }}</td>
                    {{-- <td>{{ $item->content }}</td> --}}
                    <td>
                        <form action="{{ route('book.chang', $item->id) }}" method="POST" class="status-form">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                class="btn status-btn {{ $item->status == 'active' ? 'btn-outline-success' : 'btn-outline-danger' }}"
                                style="padding: 5px 15px; min-width: 150px;">
                                {{ $item->status == 'active' ? 'เผยแพร่' : 'ไม่เผยแพร่' }}
                            </button>
                        </form>
                    </td>
                    <td>
                        <a href="{{ route('book.edit', $item->id) }}" class="btn btn-warning" title="แก้ไข">
                            <i class="bi bi-pencil-fill"></i>
                        </a>

                        <form action="{{ route('book.delete', $item->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"
                                onclick="return confirm('คุณต้องการลบบทความนี้หรือไม่')" title="ลบ">
                                <i class="bi bi-trash-fill" style="color: white"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $blogs->links() }}
    </div>
    @else
        <h2 class="text-center py-2">ไม่มีบทความ</h2>
    @endif

    <br>

    <a class="btn btn-dark" href="{{ route('form') }}">+ เขียนบทความ</a>

    <script>
        document.querySelectorAll('.status-form').forEach(function(form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const button = form.querySelector('.status-btn');
                const token = form.querySelector('input[name="_token"]').value;
                const url = form.action;

                fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                            'X-CSRF-TOKEN': token,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: '_token=' + encodeURIComponent(token) + '&_method=DELETE'
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('เกิดข้อผิดพลาด');
                        }

                        return response.text();
                    })
                    .then(() => {
                        if (button.textContent.trim() === 'เผยแพร่') {
                            button.textContent = 'ไม่เผยแพร่';
                            button.classList.remove('btn-outline-success');
                            button.classList.add('btn-outline-danger');
                        } else {
                            button.textContent = 'เผยแพร่';
                            button.classList.remove('btn-outline-danger');
                            button.classList.add('btn-outline-success');
                        }
                    })
                    .catch(error => {
                        alert('ไม่สามารถเปลี่ยนสถานะได้');
                        console.error(error);
                    });
            });
        });
    </script>
@endsection
