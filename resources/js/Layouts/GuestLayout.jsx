import ApplicationLogo from '@/Components/ApplicationLogo';
import { Link } from '@inertiajs/react';

export default function GuestLayout({ children }) {
    return (
        <div className="min-h-screen flex flex-col lg:flex-row">
            {/* Left illustration panel (hidden on small screens) */}
            <aside className="hidden lg:flex lg:w-1/2 items-center justify-center bg-[#fdeef6]">
                <div className="w-[440px] max-w-full px-10 py-12">
                    <div className="rounded-2xl overflow-hidden bg-[#fdeef6] border border-[#f6dfe9] p-8 shadow-lg">
                        <div className="flex items-center mb-4">
                            <ApplicationLogo className="h-12 w-auto" />
                        </div>
                        <h3 className="mt-6 text-2xl font-semibold text-[#481e4d]">Descubra os melhores trabalhos e inspirações.</h3>
                        <p className="mt-3 text-sm text-[#6b2f66]">Área administrativa — acessível apenas para Cássia e colaboradores autorizados.</p>
                        <div className="mt-4 text-xs text-[#6b2f66]">Arte por Irina Valeeva</div>
                    </div>
                </div>
            </aside>

            {/* Right form panel */}
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
