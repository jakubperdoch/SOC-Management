export interface Project {
	id?: string | null;
	name: string;
	description: string;
	odbor: string;
	status: string;
	studentId: any;
	teacherId: number | null;
}
