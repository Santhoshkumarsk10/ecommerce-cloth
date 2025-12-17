import React, { useEffect, useState } from "react";
import api from "../api/axios.jsx";
import { Link } from "react-router-dom";

const Categories = () => {
    const [categories, setCategories] = useState([]);

    useEffect(() => {
        api.get("/categories")
            .then(res => {
                setCategories(res.data.data ?? res.data);
            })
            .catch(err => console.log(err));
    }, []);

    return (
        <div>
            <h2>Categories</h2>

            <div className="category-list">
                {categories.map(cat => (
                    <Link key={cat.id} to={`/category/${cat.id}`}>
                        <div>{cat.name}</div>
                    </Link>
                ))}
            </div>
        </div>
    );
};

export default Categories;
