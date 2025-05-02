export default function ProductTable({ products, userLevel }) {
    return (
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
                        {userLevel !== "user" && <th className="px-4 py-3">Opções</th>}
                    </tr>
                </thead>
                <tbody className="bg-white divide-y divide-gray-200">
                    {products?.length > 0 ? (
                        products.map((product, index) => (
                            <tr key={product.id_products}>
                                <td className="px-4 py-2">{index + 1}</td>
                                <td className="px-4 py-2">{product.name}</td>
                                <td className="px-4 py-2">{product.description}</td>
                                <td className="px-4 py-2">{product.category}</td>
                                <td className="px-4 py-2">{product.sku}</td>
                                <td className="px-4 py-2">{product.quantity}</td>
                                <td className="px-4 py-2">R$ {parseFloat(product.price).toFixed(2)}</td>
                                {userLevel !== "user" && <td className="px-4 py-2"><button>botao</button></td>}
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
    );
}
