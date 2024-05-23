'use client';

import Wrapper from '../../ui/Wrapper.jsx';
import { useState } from 'react';
// import { Reorder } from 'framer-motion';
import UploadItem from '../..//ui/UploadItem.jsx';
// import { toast, ToastContainer } from 'react-toastify';
// import 'react-toastify/dist/ReactToastify.css';
import axios from '../../lib/axios.js';
// import { useRouter } from 'next/navigation';

const Page = () => {
   const [images, setImages] = useState([]);
   // const router = useRouter();

   const handleDroppedFiles = (files) => {
      Array.from(files).forEach((file) => {
         if (!file.type.startsWith('image/')) {
            // toast.error(`"${file.name}" is not an image.`);
            return;
         }

         setImages((prevImages) => {
            if (!prevImages.some((image) => image.name === file.name)) {
               return [...prevImages, file];
            } else {
               // toast.error(`"${file.name}" already exists in the list.`);
               return prevImages;
            }
         });
      });
   };

   const removeImage = (index) => {
      setImages((prevImages) => prevImages.filter((image, i) => i !== index));
   };

   const handleUpload = (e) => {
      e.preventDefault();

      if (images.length === 0) {
         // toast.error('Please add at least one image.');
         return;
      }

      const formData = new FormData();

      images.forEach((image, index) => {
         formData.append(`images[${index}]`, image);
      });

      axios
         .post('/api/v1/images', formData, {
            headers: {
               'Content-Type': 'multipart/form-data',
            },
         })
         .then(() => {
            // router.push('/');
         })
         .catch((err) => {
            console.log(err);
         });
   };

   return (
      <Wrapper>
         {/*<ToastContainer position={'bottom-right'} autoClose={1500} />*/}
         <div>
            <label
               htmlFor="image"
               className="flex h-44 w-full cursor-pointer items-center justify-center rounded-lg border-2 border-dashed border-gray-200 bg-gray-100 font-medium text-gray-500"
               onDragOver={(e) => e.preventDefault()}
               onDrop={(e) => {
                  e.preventDefault();
                  handleDroppedFiles(e.dataTransfer.files);
               }}
            >
               Drop or click to upload files
            </label>
            <input
               type="file"
               accept="image/*"
               name="image"
               id="image"
               className="sr-only"
               multiple
               onChange={(e) => handleDroppedFiles(e.target.files)}
            />
         </div>

         {/*<Reorder.Group values={images} onReorder={setImages} axis="y" className="mt-4 space-y-4">*/}
         {/*   {images.map((image, index) => (*/}
         {/*      <Reorder.Item key={image.name} value={image} className="cursor-grab">*/}
         {/*         <UploadItem image={image} key={image.name} onRemove={() => removeImage(index)} />*/}
         {/*      </Reorder.Item>*/}
         {/*   ))}*/}
         {/*</Reorder.Group>*/}
         <div className="mt-4 flex items-center justify-center">
            <button onClick={handleUpload} className="btn btn-info w-full text-white ">
               Upload
            </button>
         </div>
      </Wrapper>
   );
};

export default Page;
