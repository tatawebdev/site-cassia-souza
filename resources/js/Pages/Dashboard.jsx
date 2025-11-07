import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import { useEffect, useState } from 'react';
import axios from 'axios';

export default function Dashboard() {
    const [stats, setStats] = useState(null);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        setLoading(true);
        axios
            .get(route('dashboard.stats'))
            .then((res) => setStats(res.data))
            .catch((err) => console.error('Erro ao carregar estatísticas', err))
            .finally(() => setLoading(false));
    }, []);

    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Painel
                </h2>
            }
        >
            <Head title="Painel" />

            <div className="py-6">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="grid grid-cols-1 gap-6 md:grid-cols-3">
                        <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg p-6">
                            <h3 className="text-sm font-medium text-gray-500">Contatos (últimos 30 dias)</h3>
                            <div className="mt-4 text-3xl font-semibold text-gray-900">
                                {loading ? '...' : stats?.total_contacts ?? 0}
                            </div>
                        </div>

                        <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg p-6">
                            <h3 className="text-sm font-medium text-gray-500">Empresas</h3>
                            <div className="mt-4 text-3xl font-semibold text-gray-900">
                                {loading ? '...' : stats?.companies ?? 0}
                            </div>
                        </div>

                        <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg p-6">
                            <h3 className="text-sm font-medium text-gray-500">Pessoas físicas</h3>
                            <div className="mt-4 text-3xl font-semibold text-gray-900">
                                {loading ? '...' : stats?.individuals ?? 0}
                            </div>
                        </div>
                    </div>

                    <div className="mt-6 grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg p-6">
                            <h3 className="text-sm font-medium text-gray-500">Interações</h3>
                            <div className="mt-4 flex items-center gap-6">
                                <div>
                                    <div className="text-xs text-gray-500">Aberto</div>
                                    <div className="text-2xl font-semibold">{loading ? '...' : stats?.interactions?.open ?? 0}</div>
                                </div>
                                <div>
                                    <div className="text-xs text-gray-500">Finalizado</div>
                                    <div className="text-2xl font-semibold">{loading ? '...' : stats?.interactions?.finalized ?? 0}</div>
                                </div>
                                <div>
                                    <div className="text-xs text-gray-500">Mensagens (30d)</div>
                                    <div className="text-2xl font-semibold">{loading ? '...' : stats?.messages_total ?? 0}</div>
                                </div>
                            </div>
                        </div>

                        <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg p-6">
                            <h3 className="text-sm font-medium text-gray-500">Contatos por dia</h3>
                            <div className="mt-4 text-sm text-gray-700">
                                {loading && 'Carregando gráfico...'}
                                {!loading && stats?.contacts_over_time && stats.contacts_over_time.length === 0 && (
                                    <div>Nenhum contato no período.</div>
                                )}
                                {!loading && stats?.contacts_over_time && stats.contacts_over_time.length > 0 && (
                                    <ul className="space-y-1">
                                        {stats.contacts_over_time.map((c) => (
                                            <li key={c.date} className="flex justify-between">
                                                <span>{c.date}</span>
                                                <span className="font-semibold">{c.count}</span>
                                            </li>
                                        ))}
                                    </ul>
                                )}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
