import React, { useEffect, useState } from "react";
import api from "../api/axios";

const Cart = () => {
    const [cart, setCart] = useState([]);

    useEffect(() => {
        api.get("/cart")
            .then(res => setCart(res.data))
            .catch(err => console.log(err));
    }, []);

    const removeItem = (id) => {
        api.delete(`/cart/${id}`)
            .then(() => setCart(cart.filter(item => item.id !== id)))
            .catch(err => console.log(err));
    }

    return (
        <div>
            <h2>Cart</h2>
            {cart.map(item => (
                <div key={item.id}>
                    {item.product.name} - {item.variant.sku} - {item.variant.price}
                    <button onClick={() => removeItem(item.id)}>Remove</button>
                </div>
            ))}
        </div>
    );
};

export default Cart;
