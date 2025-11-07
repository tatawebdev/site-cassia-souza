import ApplicationLogo from '@/Components/ApplicationLogo';
import { Link } from '@inertiajs/react';

export default function GuestLayout({ children }) {
    return (
        <div className="min-h-screen flex flex-col lg:flex-row">
            {/* Left illustration panel (hidden on small screens) */}
            <aside
                className="hidden lg:flex lg:w-1/2 items-center justify-center bg-gradient-to-br from-[#fdeef6] via-[#f6dfe9] to-white"
                style={{
                    backgroundImage: "url('/sistema/bg-fundo.jpg')",
                    backgroundSize: 'cover',
                    backgroundPosition: 'center',
                    position: 'relative',
                }}
            >
                <div className="absolute inset-0 bg-white/60 backdrop-blur-sm"></div>
                <div className="relative z-10 w-[440px] max-w-full px-10 py-12 flex flex-col items-center">
                    <div className="rounded-2xl overflow-hidden bg-white/80 border border-[#f6dfe9] p-10 shadow-2xl flex flex-col items-center">
                        <div className="flex items-center mb-6 justify-center w-full">
                            <ApplicationLogo className="h-20 w-auto drop-shadow-lg" />
                        </div>
                        <h3 className="mt-4 text-3xl font-extrabold text-[#481e4d] text-center tracking-tight">
                            Área Administrativa
                        </h3>
                        <p className="mt-4 text-base text-[#6c3a6e] text-center">
                            Bem-vindo ao painel administrativo. Gerencie processos, clientes e documentos com facilidade e segurança.
                        </p>
                    </div>
                </div>
            </aside>
            <main className="flex-1 flex items-center justify-center bg-white">
                <div className="w-full max-w-md px-6 py-10">
                    {children}
                    <footer className="mt-8 text-center text-sm text-gray-400">
                        © {new Date().getFullYear()} Cassia Souza Advocacia
                    </footer>
                </div>
            </main>
        </div>
    );
}
