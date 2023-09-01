import { ComponentFixture, TestBed } from '@angular/core/testing';

import { EditLabServiceComponent } from './edit-lab-service.component';

describe('EditLabServiceComponent', () => {
  let component: EditLabServiceComponent;
  let fixture: ComponentFixture<EditLabServiceComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [EditLabServiceComponent]
    });
    fixture = TestBed.createComponent(EditLabServiceComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
