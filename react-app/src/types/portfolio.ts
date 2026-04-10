export interface Project {
  id: string;
  title: string;
  category: string;
  location: string;
  area: string;
  year: string;
  budget: string;
  description: string;
  images: string[];
  features: string[];
  challenges: string[];
  solutions: string[];
}

export interface Service {
  id: string;
  title: string;
  description: string;
  features: string[];
  price: string;
}

export interface Testimonial {
  id: string;
  name: string;
  role: string;
  company: string;
  content: string;
  rating: number;
  image: string;
}