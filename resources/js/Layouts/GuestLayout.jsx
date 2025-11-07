import ApplicationLogo from '@/Components/ApplicationLogo';
import { Link } from '@inertiajs/react';

export default function GuestLayout({ children }) {
    return (
        <div className="flex min-h-screen flex-col items-center bg-[#efdac7] pt-6 sm:justify-center sm:pt-0">
            <div>
                <Link href="/">
                    <ApplicationLogo className="h-[150px] fill-current text-[#590854]" />
                </Link>
            </div>

            <div className="mt-6 w-full overflow-hidden bg-white/90 px-6 py-4 shadow-md sm:max-w-md sm:rounded-lg border border-[#e3b16f]">
                <div className="p-4 rounded-md bg-white">
                    {children}
                </div>
            </div>
        </div>
    );
}
