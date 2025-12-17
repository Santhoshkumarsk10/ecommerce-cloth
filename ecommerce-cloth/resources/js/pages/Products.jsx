import React, { useEffect, useState } from "react";
import { useParams, Link } from "react-router-dom";
import api from "../api/axios";

const product = () => {
    const { categoryId } = useParams();
    const [products, setProducts] = useState([]);

    useEffect(() => {
        let url = "/products";
        api.get(url)
            .then(res => setProducts(res.data))
            .catch(err => console.log(err));
    }, []);
    return (
        <div>
            <h2>Products</h2>
            <div className="product-list">
                {products.map(p => (
                    <Link key={p.id} to={`/product/${p.id}`}>
                        <div>
                            <h4>{p.name}</h4>
                            {/* <p>Price: {p.variants[0]?.price}</p> */}
                        </div>
                    </Link>
                ))}
            </div>
        </div>
    );
};

export default product;
