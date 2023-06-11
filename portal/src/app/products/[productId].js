import { useRouter } from 'next/router';
import React from 'react'

function Product() {
    const router = useRouter();
    const id = router.query.productId;
  return (
    <div>[productId]</div>
  )
}

export default Product;