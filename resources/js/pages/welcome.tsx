import { Link } from '@inertiajs/react';
import { FaSignInAlt, FaUserPlus } from 'react-icons/fa';

export default function LoginRegisterButtons() {
  return (
    <div className="min-h-screen flex flex-col items-center justify-center bg-gray-100 px-4">
      <h1 className="text-2xl md:text-3xl font-bold text-gray-800 mb-8 text-center">
        Rede Parcerias - Controle de Estoques
      </h1>

      <div className="flex space-x-8 mb-4">
        <div className="flex flex-col items-center">
          <Link
            href="/login"
            className="w-24 h-24 flex items-center justify-center bg-teal-500 rounded-md shadow-md hover:shadow-xl transform hover:-translate-y-1 transition duration-300"
          >
            <FaSignInAlt className="text-white text-3xl" />
          </Link>
          <span className="mt-2 text-gray-700 font-medium">Login</span>
        </div>

        <div className="flex flex-col items-center">
          <Link
            href="/register"
            className="w-24 h-24 flex items-center justify-center bg-pink-500 rounded-md shadow-md hover:shadow-xl transform hover:-translate-y-1 transition duration-300"
          >
            <FaUserPlus className="text-white text-3xl" />
          </Link>
          <span className="mt-2 text-gray-700 font-medium">Registrar</span>
        </div>
      </div>

      <div className="mt-10">

        <img src="/logo-rp.svg" alt="Logo" className="h-10" />
      </div>
    </div>
  );
}
