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

            <div className="bg-white rounded-xl border border-gray-100 shadow-md px-6 py-6">
                <div className="mb-6 text-center">
                    <div className="flex justify-center mb-4">
                        <ApplicationLogo className="h-16 w-auto" />
                    </div>
                    <h2 className="text-2xl font-semibold text-gray-800">Acesso interno — Cássia Souza Advocacia</h2>
                    <p className="mt-1 text-sm text-gray-600">Área restrita para colaboradores e equipe.</p>
                    {status && (
                        <div className="mt-4 inline-block px-4 py-2 text-sm text-green-800 bg-green-100 border border-green-200 rounded">
                            {status}
                        </div>
                    )}
                </div>

                <form onSubmit={submit} className="space-y-6">
                    {/* Social sign-in (visual only) */}
                    <div className="flex flex-col gap-3">
                        <button type="button" onClick={() => window.location = route('google.redirect')} className="flex items-center justify-center gap-3 border border-gray-200 rounded-md px-3 py-2 text-sm bg-white hover:shadow-sm">
                            <svg className="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M21.6 12.2c0-.7-.1-1.3-.2-1.9H12v3.6h5.7c-.2 1.1-.8 2-1.6 2.6v2.1h2.6c1.5-1.4 2.4-3.5 2.4-6.4z" fill="#4285F4"/><path d="M12 22c2.6 0 4.8-.9 6.4-2.5l-2.6-2.1c-.7.5-1.6.9-3.8.9-3 0-5.5-2-6.4-4.7H3.1v2.9C4.7 19.7 8 22 12 22z" fill="#34A853"/><path d="M5.6 13.6c-.2-.5-.4-1-.4-1.6s.1-1.1.4-1.6V7.5H3.1C2.3 8.9 2 10.4 2 12s.3 3.1 1.1 4.5l2.5-2.9z" fill="#FBBC05"/><path d="M12 6.1c1.4 0 2.6.5 3.6 1.4l2.7-2.7C16.7 3 14.6 2 12 2 8 2 4.7 4.3 3.1 7.5l2.5 2.5C6.5 8.1 9 6.1 12 6.1z" fill="#EA4335"/></svg>
                                <span>Entrar com Google</span>
                        </button>
                    </div>

                    <div className="flex items-center gap-3">
                        <div className="flex-1 h-px bg-gray-200" />
                        <div className="text-xs text-gray-400">Ou</div>
                        <div className="flex-1 h-px bg-gray-200" />
                    </div>

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

                    {/* Removido 'Lembrar-me' e 'Esqueceu a senha' — acesso interno apenas */}

                    <div>
                        <PrimaryButton className="w-full py-3 text-base bg-[#481e4d] hover:bg-[#3e173f] border-[#481e4d]" disabled={processing}>
                            {processing ? 'Entrando...' : 'Entrar'}
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </GuestLayout>
    );
}
