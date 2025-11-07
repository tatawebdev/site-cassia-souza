import Checkbox from '@/Components/Checkbox';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import GuestLayout from '@/Layouts/GuestLayout';
import ApplicationLogo from '@/Components/ApplicationLogo';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Login({ status, canResetPassword }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        email: '',
        password: '',
        remember: false,
    });

    const submit = (e) => {
        e.preventDefault();

        post(route('login'), {
            onFinish: () => reset('password'),
        });
    };

    return (
        <GuestLayout>
            <Head title="Entrar" />
                <div className="mb-6 text-center">
                    <h2 className="text-2xl font-semibold text-gray-800">Entrar na sua conta</h2>
                    <p className="mt-1 text-sm text-gray-600">Acesse sua área segura para gerenciar suas informações.</p>
                    {status && (
                        <div className="mt-4 inline-block px-4 py-2 text-sm text-green-800 bg-green-100 border border-green-200 rounded">
                            {status}
                        </div>
                    )}
                </div>

                <form onSubmit={submit} className="space-y-6">
                    <div>
                        <InputLabel htmlFor="email" value="E-mail" />
                        <TextInput
                            id="email"
                            type="email"
                            name="email"
                            value={data.email}
                            className="mt-1 block w-full border-gray-300 focus:border-primary focus:ring-primary rounded-md"
                            autoComplete="username"
                            isFocused={true}
                            onChange={(e) => setData('email', e.target.value)}
                        />
                        <InputError message={errors.email} className="mt-2" />
                    </div>

                    <div>
                        <InputLabel htmlFor="password" value="Senha" />
                        <TextInput
                            id="password"
                            type="password"
                            name="password"
                            value={data.password}
                            className="mt-1 block w-full border-gray-300 focus:border-primary focus:ring-primary rounded-md"
                            autoComplete="current-password"
                            onChange={(e) => setData('password', e.target.value)}
                        />
                        <InputError message={errors.password} className="mt-2" />
                    </div>

                    <div className="flex items-center justify-between">
                        <label className="flex items-center gap-2">
                            <Checkbox
                                name="remember"
                                checked={data.remember}
                                onChange={(e) => setData('remember', e.target.checked)}
                            />
                            <span className="text-sm text-gray-700">Lembrar-me</span>
                        </label>
                        {canResetPassword && (
                            <Link href={route('password.request')} className="text-sm text-primary hover:underline">
                                Esqueceu a senha?
                            </Link>
                        )}
                    </div>

                    <div>
                        <PrimaryButton className="w-full py-3 text-base" disabled={processing}>
                            {processing ? 'Entrando...' : 'Entrar'}
                        </PrimaryButton>
                    </div>

                    <div className="mt-4 text-center text-sm text-gray-600">
                        <span>Não tem uma conta? </span>
                        <Link href={route('register')} className="text-primary hover:underline">Cadastre-se</Link>
                    </div>
                </form>
        </GuestLayout>
    );
}
