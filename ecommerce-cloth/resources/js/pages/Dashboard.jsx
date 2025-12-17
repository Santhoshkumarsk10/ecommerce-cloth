import React from "react";
import { Link } from "react-router-dom";

const Dashboard = () => {
    return (
        <div className="flex min-h-screen bg-gray-100">
            {/* Sidebar */}
            <aside className="w-64 bg-gray-900 text-white p-5">
                <h2 className="text-2xl font-bold mb-8">Admin Panel</h2>

                <ul className="space-y-4">
                    <li>
                        <Link to="/" className="block hover:text-blue-400">
                            Dashboard
                        </Link>
                    </li>
                    <li>
                        <Link to="/category" className="block hover:text-blue-400">
                            Categories
                        </Link>
                    </li>
                    <li>
                        <Link to="/products" className="block hover:text-blue-400">
                            Products
                        </Link>
                    </li>
                </ul>
            </aside>

            {/* Main Content */}
            <main className="flex-1 p-8">
                <h1 className="text-3xl font-bold mb-6">Dashboard</h1>

                {/* Stats Cards */}
                <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div className="bg-white p-6 rounded shadow">
                        <h3 className="text-gray-500">Total Products</h3>
                        <p className="text-3xl font-bold mt-2">120</p>
                    </div>

                    <div className="bg-white p-6 rounded shadow">
                        <h3 className="text-gray-500">Categories</h3>
                        <p className="text-3xl font-bold mt-2">12</p>
                    </div>

                    <div className="bg-white p-6 rounded shadow">
                        <h3 className="text-gray-500">Variants</h3>
                        <p className="text-3xl font-bold mt-2">560</p>
                    </div>
                </div>
            </main>
        </div>
    );
};

export default Dashboard;
