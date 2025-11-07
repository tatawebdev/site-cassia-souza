import ApplicationLogo from '@/Components/ApplicationLogo';
import { Link } from '@inertiajs/react';

export default function GuestLayout({ children }) {
    return (
        <div className="min-h-screen flex flex-col lg:flex-row">
            {/* Left illustration panel (hidden on small screens) */}
            <aside className="hidden lg:flex lg:w-1/2 items-center justify-center bg-[#fdeef6]">
                <div className="w-[440px] max-w-full px-10 py-12">
                    <div className="rounded-2xl overflow-hidden bg-[#fdeef6] border border-[#f6dfe9] p-10 shadow-xl flex flex-col items-center">
                        <div className="flex items-center mb-6 justify-center w-full">
                            <ApplicationLogo className="h-20 w-auto" />
                        </div>
                        <h3 className="mt-4 text-3xl font-bold text-[#481e4d] text-center">Área Administrativa</h3>
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
