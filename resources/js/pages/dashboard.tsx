import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/react';
import ProductTable from '@/components/productTable';
import { useEffect, useState } from 'react';
import Swal from 'sweetalert2';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

export default function Dashboard({ jwtToken, userLevel }) {
    const [products, setProducts] = useState([]);
    const { props } = usePage();

    if (props.flash?.success) {
        Swal.fire({
            icon: 'success',
            title: 'Sucesso!',
            text: props.flash.success,
            timer: 3000,
            showConfirmButton: false,
        });
    }

    if (props.flash?.error) {
        Swal.fire({
            icon: 'error',
            title: 'Erro',
            text: props.flash.error,
            timer: 3000,
            showConfirmButton: false,
        });
    }

    useEffect(() => {
        fetch('http://localhost:8000/api/v1/produtos', {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${jwtToken}`,
                'Accept': 'application/json',
            },
        })
        .then(res => res.json())
        .then(data => {
            setProducts(data.products);
        })
        .catch(error => {
            console.error('API error:', error);
        });
    }, []);

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />

            <div className="max-w-6xl mx-auto p-4">
                <h1 className="text-2xl font-bold mb-4">Lista de Produtos</h1>
                <ProductTable products={products} userLevel={userLevel} />
            </div>
        </AppLayout>
    );
}
