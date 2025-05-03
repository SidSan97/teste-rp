import { router, usePage } from '@inertiajs/react';
import Swal from 'sweetalert2';
import { useState } from 'react';
import EditProductModal from './edit-product-modal';

export default function ProductTable({ products, userLevel }: any) {
    const [isOpen, setIsOpen] = useState(false);
    const [selectedProduct, setSelectedProduct] = useState(null);

    const [searchName, setSearchName] = useState('');
    const [searchCategory, setSearchCategory] = useState('');
    const [minPrice, setMinPrice] = useState('');
    const [maxPrice, setMaxPrice] = useState('');

    const filteredProducts = (products || []).filter((product: { name: string; category: string; price: string; }) => {
        const matchName = product.name.toLowerCase().includes(searchName.toLowerCase());
        const matchCategory = product.category.toLowerCase().includes(searchCategory.toLowerCase());
        const matchMin = minPrice === '' || parseFloat(product.price) >= parseFloat(minPrice);
        const matchMax = maxPrice === '' || parseFloat(product.price) <= parseFloat(maxPrice);
        return matchName && matchCategory && matchMin && matchMax;
    });

    const handleDelete = (id: Number) => {
        Swal.fire({
            title: "Deseja mesmo excluir o produto?",
            showDenyButton: true,
            confirmButtonText: "Sim",
            denyButtonText: `Não`

        }).then((result) => {
            if (result.isConfirmed) {
                router.delete(`/excluir-produto/${id}`);
            }
        });
    };

    const openModal = (product: any) => {
        setSelectedProduct(product);
        setIsOpen(true);
    };

    const closeModal = () => {
        setIsOpen(false);
        setSelectedProduct(null);
    };

    const formatDate = (dateString: string) => {
        const date = new Date(dateString);
        return date.toLocaleDateString('pt-BR');
    };


    return (
        <>
            <h6 className='mb-2'>Filtros:</h6>
            <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-4">
                <div className="flex flex-col">
                    <label className="mb-1 text-sm font-medium text-gray-700">Buscar por nome</label>
                    <input
                        type="text"
                        placeholder="Ex: Camiseta"
                        className="border p-2 rounded"
                        value={searchName}
                        onChange={(e) => setSearchName(e.target.value)}
                    />
                </div>

                <div className="flex flex-col">
                    <label className="mb-1 text-sm font-medium text-gray-700">Buscar por categoria</label>
                    <input
                        type="text"
                        placeholder="Ex: Roupas"
                        className="border p-2 rounded"
                        value={searchCategory}
                        onChange={(e) => setSearchCategory(e.target.value)}
                    />
                </div>

                <div className="flex flex-col">
                    <label className="mb-1 text-sm font-medium text-gray-700">Preço mínimo</label>
                    <input
                        type="number"
                        placeholder="0.00"
                        className="border p-2 rounded"
                        value={minPrice}
                        onChange={(e) => setMinPrice(e.target.value)}
                    />
                </div>

                <div className="flex flex-col">
                    <label className="mb-1 text-sm font-medium text-gray-700">Preço máximo</label>
                    <input
                        type="number"
                        placeholder="100.00"
                        className="border p-2 rounded"
                        value={maxPrice}
                        onChange={(e) => setMaxPrice(e.target.value)}
                    />
                </div>
            </div>


            <div className="w-full overflow-x-auto rounded-lg shadow">
                <table className="min-w-[1000px] text-sm text-left text-gray-700">
                    <thead className="bg-gray-100 text-xs uppercase tracking-wider text-gray-700">
                        <tr>
                            <th className="px-4 py-3"></th>
                            <th className="px-4 py-3">Nome</th>
                            <th className="px-4 py-3">Descrição</th>
                            <th className="px-4 py-3">Categoria</th>
                            <th className="px-4 py-3">SKU</th>
                            <th className="px-4 py-3">Quantidade</th>
                            <th className="px-4 py-3">Preço</th>
                            <th className="px-4 py-3">Criado em</th>
                            <th className="px-4 py-3">Atualizado em</th>
                            {userLevel !== "user" && <th className="px-4 py-3">Opções</th>}
                        </tr>
                    </thead>
                    <tbody className="bg-white divide-y divide-gray-200">
                        {filteredProducts?.length > 0 ? (
                            filteredProducts.map((product, index) => (
                                <tr key={product.id_products}>
                                    <td className="px-4 py-2">{index + 1}</td>
                                    <td className="px-4 py-2">{product.name}</td>
                                    <td className="px-4 py-2">{product.description}</td>
                                    <td className="px-4 py-2">{product.category}</td>
                                    <td className="px-4 py-2">{product.sku}</td>
                                    <td className="px-4 py-2">{product.quantity}</td>
                                    <td className="px-4 py-2">R$ {parseFloat(product.price).toFixed(2)}</td>
                                    <td className="px-4 py-2">{formatDate(product.created_at)}</td>
                                    <td className="px-4 py-2">{formatDate(product.updated_at)}</td>
                                    <td className="px-4 py-2">
                                        {userLevel === 'admin' && (
                                            <>
                                                <button onClick={() => openModal(product)} className="text-blue-600 hover:underline mr-2">Editar</button>
                                                <button onClick={() => handleDelete(product.id_products)} className="text-red-600 hover:underline">Excluir</button>
                                            </>
                                        )}

                                        {userLevel === 'operator' && (
                                            <button onClick={() => openModal(product)} className="text-green-600 hover:underline">Atualizar Estoque</button>
                                        )}
                                    </td>

                                </tr>
                            ))
                        ) : (
                            <tr>
                                <td colSpan="7" className="text-center py-4">Nenhum produto encontrado.</td>
                            </tr>
                        )}
                    </tbody>
                </table>
            </div>

            {isOpen && selectedProduct && (
                <EditProductModal
                    product={selectedProduct}
                    onClose={closeModal}
                    userLevel={userLevel}
                />
            )}
        </>
    );
}
