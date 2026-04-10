/**
 * WordPress API Service
 * Handles all communication with WordPress REST API
 */

const WORDPRESS_API_URL = import.meta.env.VITE_WP_API_URL || 'https://www.caripropshop.com/wp-json';
const CPS_API_URL = `${WORDPRESS_API_URL}/cps/v1`;

interface Property {
  id: number;
  title: string;
  slug: string;
  content: string;
  excerpt: string;
  featured_image: string;
  thumbnail: string;
  price: string;
  price_label: string;
  area: string;
  land_area: string;
  bedrooms: string;
  bathrooms: string;
  garages: string;
  year_built: string;
  property_id: string;
  address: string;
  city: string;
  state: string;
  zip: string;
  country: string;
  latitude: string;
  longitude: string;
  types: Array<{ id: number; name: string; slug: string }>;
  status: Array<{ id: number; name: string; slug: string }>;
  features: Array<{ id: number; name: string; slug: string }>;
  date: string;
  url: string;
}

interface Agent {
  id: number;
  name: string;
  description: string;
  photo: string;
  email: string;
  phone: string;
}

interface ApiResponse<T> {
  data: T;
  error?: string;
}

class WordPressApi {
  private async request<T>(endpoint: string, options: RequestInit = {}): Promise<ApiResponse<T>> {
    try {
      const response = await fetch(`${CPS_API_URL}${endpoint}`, {
        ...options,
        headers: {
          'Content-Type': 'application/json',
          ...options.headers,
        },
      });

      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }

      const data = await response.json();
      return { data };
    } catch (error) {
      console.error('API Error:', error);
      return { data: null as T, error: (error as Error).message };
    }
  }

  // Properties
  async getProperties(params: {
    per_page?: number;
    page?: number;
    type?: string;
    status?: string;
    location?: string;
    min_price?: number;
    max_price?: number;
    bedrooms?: number;
    search?: string;
  } = {}): Promise<ApiResponse<{ properties: Property[]; total: number; pages: number }>> {
    const queryParams = new URLSearchParams();
    Object.entries(params).forEach(([key, value]) => {
      if (value !== undefined && value !== '') {
        queryParams.append(key, String(value));
      }
    });
    return this.request(`/properties?${queryParams.toString()}`);
  }

  async getProperty(id: number): Promise<ApiResponse<Property>> {
    return this.request(`/properties/${id}`);
  }

  // Property Types
  async getPropertyTypes(): Promise<ApiResponse<Array<{ id: number; name: string; slug: string; count: number }>>> {
    return this.request('/property-types');
  }

  // Agents
  async getAgents(params: { per_page?: number } = {}): Promise<ApiResponse<Agent[]>> {
    const queryParams = new URLSearchParams();
    Object.entries(params).forEach(([key, value]) => {
      if (value !== undefined) {
        queryParams.append(key, String(value));
      }
    });
    return this.request(`/agents?${queryParams.toString()}`);
  }

  // Inquiry
  async submitInquiry(data: {
    name: string;
    email: string;
    phone: string;
    message: string;
    inquiry_type?: string;
    property_id?: number;
  }): Promise<ApiResponse<{ success: boolean; message: string; inquiry_id: number }>> {
    return this.request('/inquiry', {
      method: 'POST',
      body: JSON.stringify(data),
    });
  }
}

export const wpApi = new WordPressApi();
export type { Property, Agent };
