@extends('layouts.admin.app')

@section('content')


        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
    <div class="flex items-center justify-between mb-6 whitespace-nowrap">
        <h3 class="text-lg font-bold">
            Manage Doctors
        </h3>

        <a href="{{ route('admin.doctor.create') }}" class="bg-primary text-white font-bold py-3 px-4 rounded">
            Create Doctor
        </a>
    </div>


                        @if (session('status'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                                role="alert">
                                <span class="block sm:inline">{{ session('status') }}</span>
                            </div>
                        @endif


                        <table class="table table-striped min-w-full leading-normal my-5">
                            <thead>
                                <tr>
                                    <th
                                        class="px-auto py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Name
                                    </th>
                                    <th
                                        class="px-auto py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Email
                                    </th>
                                    <th
                                        class="px-auto py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Specialty
                                    </th>
                                    <th
                                        class="px-auto py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Phone
                                    </th>
                                    <th
                                        class="px-auto py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($doctors as $doctor)
                                <tr class="py-2">
                                    <td class="py-2 border-gray-200 bg-white text-sm">
                                        <div class="flex items-center">
                                            <div class="ml-3">
                                                <p class="text-gray-900 whitespace-no-wrap">
                                                    {{ $doctor->name }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class=" border-b  bg-white text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap">{{ $doctor->email }}</p>
                                    </td>
                                    <td class=" border-b  bg-white text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap">{{ $doctor->specialty->name }}</p>
                                    </td>
                                    <td class=" border-b  bg-white text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap">{{ $doctor->phone }}</p>
                                    </td>
                                    <td class="border-b bg-white text-sm">

                                        <form action="{{ route('admin.doctor.destroy', $doctor->id) }}" method="POST">
                                            @csrf 

                                            @method('DELETE') 

                                            <button 
                                                type="submit" 
                                                class="btn btn-danger text-white font-bold py-2 px-4 rounded"
                                                >
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
@endsection