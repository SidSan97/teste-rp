import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, router, usePage } from '@inertiajs/react';
import ProductTable from '@/components/product-table';
import { useEffect, useState } from 'react';
import Swal from 'sweetalert2';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

interface DashboardProps {
    jwtToken: string;
    userLevel: string;
}

export default function Dashboard({ jwtToken, userLevel }: DashboardProps) {
    const [products, setProducts] = useState([]);
    const [showFlash, setShowFlash] = useState(true);

    const { props } = usePage();

    if (props.flash?.success && showFlash) {
        Swal.fire({
            icon: 'success',
            title: 'Sucesso!',
            text: props.flash.success,
            showConfirmButton: true,
            willClose: () => {
                setShowFlash(false);
                fetchProducts();
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
                fetchProducts();
            }
        });
    }

    const fetchProducts = () => {
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
    }

    useEffect(() => {
        fetchProducts();
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
