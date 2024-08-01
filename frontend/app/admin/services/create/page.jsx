'use client';

import React, { useState } from 'react';
import Wrapper from '../../../ui/Wrapper';
import axios from '../../../lib/axios';
import { useRouter } from 'next/navigation';
import InputError from '../../../ui/InputError';

export default function BrandCreate() {
   const router = useRouter();
   const [title, setTitle] = useState('');
   const [price, setPrice] = useState('');
   const [duration, setDuration] = useState('');
   const [errors, setErrors] = useState([]);

   const handleSubmit = (event) => {
      event.preventDefault();

      setErrors([]);

      axios
         .post('/api/v1/admin/services', {
            title: title,
            price: price,
            duration: duration,
         })
         .then((response) => {
            // TODO: show notification
            router.push('/admin/services');
         })
         .catch((error) => {
            if (error.response.data.status === 422) {
               setErrors(error.response.data.errors);
            } else {
               // TODO: show notification
            }
         });
   };

   return (
      <>
         <h1 className="p-2 text-3xl font-bold">Create Service</h1>
         <Wrapper maxWidth="max-w-xl">
            <form className="flex items-center justify-center" onSubmit={handleSubmit}>
               <div className="space-y-2">
                  <div>
                     <input
                        className={'input input-bordered w-full ' + (errors.title ? ' input-error' : '')}
                        onChange={(e) => {
                           if (errors.title) {
                              setErrors((prevErrors) => ({ ...prevErrors, title: '' }));
                           }
                           setTitle(e.target.value);
                        }}
                        value={title}
                        type="text"
                        placeholder="Title"
                     />
                     <InputError messages={errors.title} className="mt-2" />
                  </div>
                  <div>
                     <input
                        className={'input input-bordered w-full ' + (errors.price ? ' input-error' : '')}
                        onChange={(e) => {
                           if (errors.price) {
                              setErrors((prevErrors) => ({ ...prevErrors, price: '' }));
                           }
                           setPrice(e.target.value);
                        }}
                        value={price}
                        type="number"
                        placeholder="Price"
                     />
                     <InputError messages={errors.price} className="mt-2" />
                  </div>
                  <div>
                     <input
                        className={'input input-bordered w-full ' + (errors.duration ? ' input-error' : '')}
                        onChange={(e) => {
                           if (errors.duration) {
                              setErrors((prevErrors) => ({ ...prevErrors, duration: '' }));
                           }
                           setDuration(e.target.value);
                        }}
                        value={duration}
                        type="number"
                        placeholder="Duration"
                     />
                     <InputError messages={errors.duration} className="mt-2" />
                  </div>

                  <button className="btn btn-success mt-4 w-full text-white" onSubmit={handleSubmit}>
                     Submit
                  </button>
               </div>
            </form>
         </Wrapper>
      </>
   );
}
