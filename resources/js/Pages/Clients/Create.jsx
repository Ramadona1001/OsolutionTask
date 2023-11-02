import React, { useEffect } from 'react';
import Authenticated from '@/Layouts/Authenticated';
import { Head, useForm, Link } from '@inertiajs/inertia-react';
import Input from '@/Components/Input';
import Label from '@/Components/Label';
import Button from '@/Components/Button';

export default function Dashboard(props) {

    const { data, setData, post, processing, errors, reset } = useForm({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
        type:'',
    });

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.type === 'checkbox' ? event.target.checked : event.target.value);
    };

    useEffect(() => {
        return () => {
            reset('password', 'password_confirmation');
        };
    }, []);

    function handleSubmit(e) {
        e.preventDefault();
        post(route("clients.store"));
    }

    return (
        <Authenticated
            auth={props.auth}
            errors={props.errors}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Create Client</h2>}
        >
            <Head title="Posts" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 bg-white border-b border-gray-200">

                            <div className="flex items-center justify-between mb-6">
                                <Link
                                    className="px-6 py-2 text-white bg-blue-500 rounded-md focus:outline-none"
                                    href={ route("products.index") }
                                >
                                    Back
                                </Link>
                            </div>

                            <form name='createForm' onSubmit={handleSubmit}>
                                <div>
                                    <Label forInput="name" value="Name" />

                                    <Input
                                        type="text"
                                        name="name"
                                        value={data.name}
                                        className="mt-1 block w-full"
                                        autoComplete="name"
                                        isFocused={true}
                                        handleChange={onHandleChange}
                                        required
                                    />
                                </div>

                                <div className="mt-4">
                                    <Label forInput="email" value="Email" />

                                    <Input
                                        type="email"
                                        name="email"
                                        value={data.email}
                                        className="mt-1 block w-full"
                                        autoComplete="username"
                                        handleChange={onHandleChange}
                                        required
                                    />
                                </div>

                                <div className="mt-4">
                                    <Label forInput="password" value="Password" />

                                    <Input
                                        type="password"
                                        name="password"
                                        value={data.password}
                                        className="mt-1 block w-full"
                                        autoComplete="new-password"
                                        handleChange={onHandleChange}
                                        required
                                    />
                                </div>

                                <div className="mt-4">
                                    <Label forInput="password_confirmation" value="Confirm Password" />

                                    <Input
                                        type="password"
                                        name="password_confirmation"
                                        value={data.password_confirmation}
                                        className="mt-1 block w-full"
                                        handleChange={onHandleChange}
                                        required
                                    />
                                </div>

                                <div className="flex items-center justify-end mt-4">

                                    <Button className="ml-4" processing={processing}>
                                        Create
                                    </Button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </Authenticated>
    );
}
