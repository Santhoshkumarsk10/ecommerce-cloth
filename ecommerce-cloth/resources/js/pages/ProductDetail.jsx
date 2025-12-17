import React, { useEffect, useState } from "react";
import { useParams } from "react-router-dom";
import api from "../api/axios";

const ProductDetail = () => {
    const { productId } = useParams();
    const [product, setProduct] = useState({ variants: [] });

    useEffect(() => {
        api.get(`/products/${productId}`)
            .then(res => {
                setProduct({
                    ...res.data,
                    variants: res.data.variants || []
                });
            })
            .catch(err => console.log(err));
    }, [productId]);

    if (!product) return <div>Loading...</div>;

    return (
        <div style={{ padding: "20px" }}>
            <h2>{product.name}</h2>
            <p>{product.description}</p>

            <h4>Variants</h4>
            <table style={{ width: "100%", borderCollapse: "collapse" }}>
                <thead>
                    <tr>
                        <th>SKU</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Attributes</th>
                    </tr>
                </thead>
                <tbody>
                    {product.variants.map(variant => (
                        <tr key={variant.id}>
                            <td>{variant.sku}</td>
                            <td>{variant.price}</td>
                            <td>{variant.stock_qty}</td>
                            <td>
                                {variant.variant_attributes.map(attr => (
                                    <span key={attr.id} style={{ marginRight: "10px" }}>
                                        {attr.value?.value} {/* Example: L, M, XL */}
                                    </span>
                                ))}
                            </td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    );
};

export default ProductDetail;
