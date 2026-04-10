import React from 'react';
import { Link } from 'react-router-dom';
import type { Property } from '../../services/api';

interface PropertyCardProps {
  property: Property;
}

export const PropertyCard: React.FC<PropertyCardProps> = ({ property }) => {
  const formatPrice = (price: string) => {
    if (!price) return 'Price on Request';
    return new Intl.NumberFormat('id-ID', {
      style: 'currency',
      currency: 'IDR',
      maximumFractionDigits: 0,
    }).format(parseInt(price));
  };

  return (
    <div className="group bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 border border-gray-100">
      <div className="relative overflow-hidden">
        <Link to={`/property/${property.id}/${property.slug}`}>
          {property.featured_image ? (
            <img
              src={property.featured_image}
              alt={property.title}
              className="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500"
            />
          ) : (
            <div className="w-full h-64 bg-gray-200 flex items-center justify-center">
              <svg className="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.5} d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
              </svg>
            </div>
          )}
        </Link>
        
        {property.status && property.status.length > 0 && (
          <div className="absolute top-4 left-4 flex gap-2">
            {property.status.map((s) => (
              <span
                key={s.id}
                className={`px-3 py-1 text-xs font-semibold rounded-full ${
                  s.slug === 'for-sale'
                    ? 'bg-emerald-500 text-white'
                    : s.slug === 'for-rent'
                    ? 'bg-blue-500 text-white'
                    : 'bg-gray-500 text-white'
                }`}
              >
                {s.name}
              </span>
            ))}
          </div>
        )}

        <button className="absolute top-4 right-4 p-2 bg-white/90 rounded-full hover:bg-white transition-colors">
          <svg className="w-5 h-5 text-gray-600 hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
          </svg>
        </button>
      </div>

      <div className="p-5">
        <div className="flex items-center justify-between mb-2">
          <span className="text-2xl font-bold text-emerald-600">
            {formatPrice(property.price)}
            {property.price_label && (
              <span className="text-sm font-normal text-gray-500">/{property.price_label}</span>
            )}
          </span>
        </div>

        <Link to={`/property/${property.id}/${property.slug}`}>
          <h3 className="text-lg font-semibold text-gray-900 hover:text-emerald-600 transition-colors line-clamp-1 mb-3">
            {property.title}
          </h3>
        </Link>

        {property.address && (
          <div className="flex items-center text-gray-500 text-sm mb-4">
            <svg className="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            {property.address}
            {property.city && `, ${property.city}`}
          </div>
        )}

        <div className="flex items-center gap-4 pt-4 border-t border-gray-100">
          {property.bedrooms && (
            <div className="flex items-center text-gray-600">
              <svg className="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
              </svg>
              <span className="text-sm font-medium">{property.bedrooms} Beds</span>
            </div>
          )}
          {property.bathrooms && (
            <div className="flex items-center text-gray-600">
              <svg className="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
              </svg>
              <span className="text-sm font-medium">{property.bathrooms} Baths</span>
            </div>
          )}
          {property.area && (
            <div className="flex items-center text-gray-600">
              <svg className="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
              </svg>
              <span className="text-sm font-medium">{property.area} sq ft</span>
            </div>
          )}
        </div>

        {property.types && property.types.length > 0 && (
          <div className="flex flex-wrap gap-2 mt-4">
            {property.types.slice(0, 2).map((type) => (
              <span
                key={type.id}
                className="px-2 py-1 text-xs bg-gray-100 text-gray-600 rounded"
              >
                {type.name}
              </span>
            ))}
          </div>
        )}
      </div>
    </div>
  );
};

export default PropertyCard;
