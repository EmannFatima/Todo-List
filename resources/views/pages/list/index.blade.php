@extends('layouts.app', [
    'title' => 'ToDo List',
])
@section('content')
    <div class="col-4 container">
        <div class="card-title text-center text-bg-dark">
            <h2>To-Do List</h2>
        </div>

        <div class="card-body">
            <form action="{{ route('list.store') }}" method="POST">
                @csrf
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="todo" placeholder="Add to-do" aria-label="Add to-do"
                        aria-describedby="basic-addon2">
                    @error('todo')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <div class="input-group-append">
                        <a href="#"> <button class="btn btn-outline-secondary"
                                type="submit">{{ __('Add') }}</button></a>
                    </div>
                </div>
            </form>
            @foreach ($list as $todolist)
                <div class="input-group">
                    <div class="input-with-icon">
                        <input type="text " id="todo-{{ $todolist->id }}" value="{{ $todolist->description }}"
                            class="form-control" aria-describedby="basic-addon2" disabled>
                        <div class="icons-container">
                            <a href="#" onclick="edit(this,{{ $todolist->id }})"> <i
                                    class="fa-solid fa-pencil text-black"></i></a>
                            {{-- <form id="form" action="{{ route('list.destroy', $todolist->id) }}"
            method="POST">
            @csrf
            @method('DELETE')
            {{ method_field('DELETE') }} --}}
                            <a href="#"><i class="fa-solid fa-trash text-black"
                                    onclick="destroy({{ $todolist->id }})"></i> </a>
                            {{-- </form> --}}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
@endsection


@push('js')
    <script>
        function edit(e, id) {
            //accessing todolist input element
            $(`#todo-${id}`).prop('disabled', false);

            //cursor
            $(`#todo-${id}`).focus();
            var strLength = $(`#todo-${id}`).val().length;
            $(`#todo-${id}`)[0].setSelectionRange(strLength, strLength);

            //changing button text from edit to save
            $(e).html('<i class="fa-solid fa-square-check"></i>')

            //swal on clicking save button
            $(e).click(function() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Save it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/list/${id}`,
                            type: `POST`,
                            data: {
                                '_token': "{{ csrf_token() }}",
                                '_method': "PATCH",
                                'todo': $(`#todo-${id}`)
                            .val(), //getting input value from todo list input field
                            },
                            success: function(result) {
                                Swal.fire(
                                    'Saved!',
                                    'Your file has been saved.',
                                    'success'
                                ).then(() => {
                                    location.reload();
                                })
                            }
                        });
                    }
                })
            })
        }

        function destroy(id) {

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/list/${id}`,
                        type: `POST`,
                        data: {
                            '_token': "{{ csrf_token() }}",
                            '_method': "DELETE"
                        },
                        success: function(result) {
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            ).then(() => {
                                location.reload();
                            })
                        }
                    });
                }
            })
        }
    </script>
@endpush
