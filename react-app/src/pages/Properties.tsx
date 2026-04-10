import React, { useState, useEffect } from 'react';
import { useSearchParams } from 'react-router-dom';
import { PropertyGrid } from '../components/property/PropertyGrid';
import { PropertySearch } from '../components/search/PropertySearch';
import { wpApi } from '../services/api';
import type { Property } from '../services/api';

const Properties: React.FC = () => {
  const [searchParams, setSearchParams] = useSearchParams();
  const [properties, setProperties] = useState<Property[]>([]);
  const [loading, setLoading] = useState(true);
  const [totalPages, setTotalPages] = useState(1);
  const [currentPage, setCurrentPage] = useState(1);

  useEffect(() => {
    const fetchProperties = async () => {
      setLoading(true);
      const params = {
        per_page: 12,
        page: currentPage,
        type: searchParams.get('type') || undefined,
        status: searchParams.get('status') || undefined,
        location: searchParams.get('location') || undefined,
        min_price: searchParams.get('minPrice') ? parseInt(searchParams.get('minPrice')!) : undefined,
        max_price: searchParams.get('maxPrice') ? parseInt(searchParams.get('maxPrice')!) : undefined,
        bedrooms: searchParams.get('bedrooms') ? parseInt(searchParams.get('bedrooms')!) : undefined,
        search: searchParams.get('keyword') || undefined,
      };

      const { data, error } = await wpApi.getProperties(params);
      
      if (data && !error) {
        setProperties(data.properties || []);
        setTotalPages(data.pages || 1);
      } else {
        setProperties([]);
      }
      setLoading(false);
    };

    fetchProperties();
  }, [searchParams, currentPage]);

  const handlePageChange = (page: number) => {
    setCurrentPage(page);
    window.scrollTo({ top: 0, behavior: 'smooth' });
  };

  return (
    <div className="min-h-screen bg-gray-50">
      <div className="bg-gradient-to-r from-emerald-600 to-teal-600 py-16">
        <div className="container mx-auto px-4">
          <h1 className="text-4xl font-bold text-white mb-4">Find Your Dream Property</h1>
          <p className="text-emerald-100 text-lg">Browse through our extensive collection of properties</p>
        </div>
      </div>

      <div className="container mx-auto px-4 -mt-8">
        <div className="mb-8">
          <PropertySearch />
        </div>

        <div className="bg-white rounded-xl shadow-md p-6 mb-8">
          <div className="flex flex-wrap gap-4 items-center justify-between">
            <div className="flex gap-2">
              <button className="px-4 py-2 bg-emerald-600 text-white rounded-lg font-medium">
                All
              </button>
              <button className="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50">
                For Sale
              </button>
              <button className="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50">
                For Rent
              </button>
            </div>
            <div className="flex gap-2">
              <select className="px-4 py-2 border border-gray-300 rounded-lg">
                <option>Default Order</option>
                <option>Price: Low to High</option>
                <option>Price: High to Low</option>
                <option>Newest First</option>
              </select>
            </div>
          </div>
        </div>

        <PropertyGrid
          properties={properties}
          loading={loading}
          totalPages={totalPages}
          currentPage={currentPage}
          onPageChange={handlePageChange}
        />
      </div>
    </div>
  );
};

export default Properties;
