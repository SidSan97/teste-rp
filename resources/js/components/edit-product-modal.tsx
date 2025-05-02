import { Inertia } from '@inertiajs/inertia';
import React, { useState, useEffect } from 'react';
import Swal from 'sweetalert2';

export default function EditProductModal({ product, onClose }) {
    const [form, setForm] = useState({
        id: '',
        name: '',
        description: '',
        quantity: '',
        price: '',
        category: '',
        sku: '',
    });

    const labels = ['Nome', 'Descrição', 'Quantidade', 'Preço', 'Categoria', 'SKU'];

    useEffect(() => {
        if (product) {
            setForm({
                id: product.id_products,
                name: product.name,
                description: product.description,
                quantity: product.quantity,
                price: product.price,
                category: product.category,
                sku: product.sku,
            });
        }
    }, [product]);

    const handleChange = (e) => {
        const { name, value } = e.target;
        setForm({ ...form, [name]: value });
    };

    const handleSubmit = () => {
        Inertia.put(`/editar-produto/${form.id}`, form, {});
    };

    return (
        <div className="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div className="bg-white w-full max-w-lg rounded-lg shadow-lg p-6 relative">
                <h2 className="text-xl font-bold mb-4">Editar Produto</h2>
                <form onSubmit={handleSubmit} className="space-y-4">
                    {['name', 'description', 'quantity', 'price', 'category', 'sku'].map((field, index) => (
                        <div key={field}>
                            <label className="block text-sm font-medium mb-1 capitalize">{labels[index]}</label>
                            <input
                                type={field === 'price' || field === 'quantity' ? 'number' : 'text'}
                                step={field === 'price' || field === 'quantity' ? '01' : undefined}
                                name={field}
                                value={form[field]}
                                onChange={handleChange}
                                className="w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            />
                        </div>
                    ))}

                    <div className="flex justify-end gap-3 mt-6">
                        <button type="button" onClick={onClose} className="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400">
                            Cancelar
                        </button>

                        <button type="submit" className="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">
                            Salvar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    );
}
