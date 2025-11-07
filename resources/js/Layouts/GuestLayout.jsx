import ApplicationLogo from '@/Components/ApplicationLogo';
import { Link } from '@inertiajs/react';

export default function GuestLayout({ children }) {
    return (
        <div className="min-h-screen flex items-center justify-center bg-gradient-to-br from-[#f3f4f6] via-[#efeae6] to-[#f8f8f5] px-4 py-12">
            {/* Logo floating on top */}
            <div className="absolute top-8 left-1/2 transform -translate-x-1/2">
                <Link href="/">
                    <div className="bg-white/60 backdrop-blur-sm rounded-full p-3 shadow-md border border-white/30">
                        <ApplicationLogo className="h-20 sm:h-24 w-auto fill-current text-gray-700" />
                    </div>
                </Link>
            </div>

            <div className="w-full max-w-md rounded-2xl border border-white/20 bg-white/60 backdrop-blur-md px-8 py-8 shadow-2xl">
                {children}
            </div>

            <footer className="absolute bottom-6 text-sm text-gray-500">
                © {new Date().getFullYear()} Cassia Souza Advocacia
            </footer>
        </div>
    );
}
