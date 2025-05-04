import AppLayout from '@/layouts/app-layout';
import { BreadcrumbItem } from '@/types';
import { useForm, usePage } from '@inertiajs/react';
import { Head, router } from '@inertiajs/react';
import { StyledInput, StyledTextarea } from '@/components/ui/styled-input';
import { Inertia } from '@inertiajs/inertia';
import Swal from 'sweetalert2';
import { useEffect, useState } from 'react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Criar Produto',
        href: '/criar-produtos',
    },
];

interface FlashProps {
    success?: string;
    error?: string;
}

export default function CreateProduct() {

    const { props } = usePage<{ flash: FlashProps }>();
    const [showFlash, setShowFlash] = useState(true);

    console.log(props)

    const { data, setData, processing, errors } = useForm({
        name: '',
        description: '',
        quantity: '',
        price: '',
        category: '',
        sku: '',
    });

    const handleSubmit = (e: any) => {
        e.preventDefault();
        router.post('/criar-produtos', data);
    };

    if (props.flash?.success && showFlash) {
        Swal.fire({
            icon: 'success',
            title: 'Sucesso',
            text: props.flash.success,
            showConfirmButton: true,
            willClose: () => {
                setShowFlash(false);
                location.reload()
            }
        });
    }

    if (props.flash?.error && showFlash) {
        Swal.fire({
            icon: 'error',
            title: 'Erro',
            text: props.flash.error,
            showConfirmButton: true,
            willClose: () => {
                setShowFlash(false);
                location.reload()
            }
        });
    }

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Cadastrar Produto" />

            <div className="w-full mx-auto p-6 rounded shadow">
                <h1 className="text-2xl font-bold mb-6">Cadastrar Produto</h1>

                <form onSubmit={handleSubmit} className="space-y-6">
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label className="block font-semibold mb-1" htmlFor="name">Nome</label>
                            <StyledInput
                                id="name"
                                type="text"
                                value={data.name}
                                onChange={(e) => setData('name', e.target.value)}
                            />
                            {errors.name && <p className="text-red-500 text-sm mt-1">{errors.name}</p>}
                        </div>

                        <div>
                            <label className="block font-semibold mb-1" htmlFor="category">Categoria</label>
                            <StyledInput
                                id="category"
                                type="text"
                                value={data.category}
                                onChange={(e) => setData('category', e.target.value)}
                            />
                            {errors.category && <p className="text-red-500 text-sm mt-1">{errors.category}</p>}
                        </div>

                        <div>
                            <label className="block font-semibold mb-1" htmlFor="quantity">Quantidade</label>
                            <StyledInput
                                id="name"
                                type="number"
                                value={data.quantity}
                                onChange={(e) => setData('quantity', e.target.value)}
                            />
                            {errors.quantity && <p className="text-red-500 text-sm mt-1">{errors.quantity}</p>}
                        </div>

                        <div>
                            <label className="block font-semibold mb-1" htmlFor="price">Preço</label>
                            <StyledInput
                                id="price"
                                type="number"
                                step="0.01"
                                value={data.price}
                                onChange={(e) => setData('price', e.target.value)}
                            />
                            {errors.price && <p className="text-red-500 text-sm mt-1">{errors.price}</p>}
                        </div>

                        <div>
                            <label className="block font-semibold mb-1" htmlFor="description">Descrição</label>
                            <StyledTextarea
                                id="description"
                                value={data.description}
                                onChange={(e) => setData('description', e.target.value)}
                            />
                            {errors.description && <p className="text-red-500 text-sm mt-1">{errors.description}</p>}
                        </div>

                        <div>
                            <label className="block font-semibold mb-1" htmlFor="sku">SKU</label>
                            <StyledInput
                                id="sku"
                                type="text"
                                value={data.sku}
                                onChange={(e) => setData('sku', e.target.value)}
                            />
                            {errors.sku && <p className="text-red-500 text-sm mt-1">{errors.sku}</p>}
                        </div>
                    </div>

                    <div className="flex justify-end mt-6">
                        <button
                            type="submit"
                            disabled={processing}
                            className="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded disabled:opacity-50"
                        >
                            {processing ? 'Salvando...' : 'Cadastrar Produto'}
                        </button>
                    </div>
                </form>
            </div>
        </AppLayout>
    );
}
